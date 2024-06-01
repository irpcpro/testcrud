<?php

namespace App\Http\Controllers\Factories\Order;

use App\Http\Controllers\Factories\FactoryConnector;
use App\Http\Requests\API\V1\Order\OrderStoreAPIRequest;
use App\Http\Resources\V1\Order\OrderStoreFailedResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class OrderStoreFactoryController extends OrderFactoryController {


    /**
     * @var Collection $orders
     * @var Product $product
     * @var int $count
     */
    private Collection $orders;

    /** @var OrderStoreFailedResource[] $errorCountOrders */
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
    private function validateCountOrders(): void{
        $this->orders->map(function($item){
            if($item['count'] > $item['product']->inventory){
                $this->errorCountOrders[] = (new OrderStoreFailedResource($item['product']))->toArray($this->request);
            }
        });
    }

    private function calculateOrderTotalPrice(): int {
        return $this->orders->sum(fn($item) => $item['product']->price * $item['count']);
    }

    private function calculateOrderCount(): int {
        return $this->orders->sum('count');
    }

    private function createOrderProductsList(): Collection {
        return $this->orders->mapWithKeys(function($item) {
            return [
                $item['product']->id => [
                    'count' => $item['count'],
                    'price' => $item['product']->price,
                    'product' => $item['product'],
                ]
            ];
        });
    }

    public function store(){
        // get the products out of request
        $this->convertOrdersToModel();

        // factory connector through the system
        $response = new FactoryConnector();
        $response->setStatus(false)->setMessage('')->setData('');

//        DB::beginTransaction();
        try {
            // validations
            $this->validateCountOrders();
            if(!empty($this->errorCountOrders)){
                $response->setMessage('error on products inventories.')->setData($this->errorCountOrders);
                return $response;
            }

            // get the TotalPrice and OrderCount
            $orderTotalPrice = $this->calculateOrderTotalPrice();
            $orderCount = $this->calculateOrderCount();

            // create the order
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'count' => $orderCount,
                'total_price' => $orderTotalPrice,
            ]);

            // get data and sync the orderProducts
            $orderProducts = $this->createOrderProductsList();

            // sync the order products
            $order->syncOrderProducts($orderProducts);

            // ready data and return
            $response->setData($order)->setStatus(true)->setMessage('orders have created.');
//            DB::commit();
            return $response;
        }catch (\Exception $exception){
//            DB::rollBack();
            // set data to pass through the system
            $response->setMessage('error on store order.')->setData('')->setStatus(false);
            Log::error('error on storing order', [$exception->getMessage()]);
            return $response;
        }
    }

}
