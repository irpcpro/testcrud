<?php

namespace App\Http\Controllers\Factories\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\FactoryConnector;
use App\Http\Requests\API\V1\Order\OrderStoreAPIRequest;
use App\Http\Resources\V1\Order\OrderStoreFailedResource;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class OrderStoreFactoryController extends Controller {


    /**
     * @var Collection $orders
     * @var Product $product
     * @var int $count
     */
    private Collection $orders;
    private array $errorCountOrders = [];

    public function __construct(
        private OrderStoreAPIRequest $request
    ){
    }

    // convert order to product
    private function convertOrdersToModel(){
        // get all products
        $orders = collect($this->request->validated('orders'));
        $productIDs = $orders->pluck('product_id');
        $products = new Product();
        $products = $products::whereIn($products->getKeyName(), $productIDs)->get();

        // make the array of orders with models and count
        $this->orders = $products->map(function($item) use ($orders) {
            return [
                'product' => $item,
                'count' => $orders->firstWhere('product_id', $item->id)['count'],
            ];
        });
    }

    // check the count of purchase
    private function checkCountOrders(): void{
        $this->orders->map(function($item){
            if($item['count'] > $item['product']->inventory){
                $this->errorCountOrders[] = (new OrderStoreFailedResource($item['product']))->toArray($this->request);
            }
        });
    }

    public function store(){
        // get the products out of request
        $this->convertOrdersToModel();

        // factory connector through the system
        $response = new FactoryConnector();
        $response->setStatus(false)->setMessage('')->setData('');

        try {
            // validations
            $this->checkCountOrders();
            if(!empty($this->errorCountOrders)){
                $response->setMessage('error on products inventories.')->setData($this->errorCountOrders);
                return $response;
            }

            // place the order
            $order = '';
            // make order & product relation  -  an order =>( can have )=> n product !
            // TODO - Place the order


            $response->setData('')->setStatus(true)->setMessage('orders have created.');
            return $response;
        }catch (\Exception $exception){
            // set data to pass through the system
            $response->setMessage('error on store order.')->setData('')->setStatus(false);
            Log::error('error on storing order', [$exception->getMessage()]);
            return $response;
        }
    }

}
