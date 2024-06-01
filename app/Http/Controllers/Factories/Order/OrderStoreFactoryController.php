<?php

namespace App\Http\Controllers\Factories\Order;

use App\Http\Controllers\Factories\FactoryConnector;
use App\Http\Requests\API\V1\Order\OrderStoreAPIRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderStoreFactoryController extends OrderFactoryController {

    public function __construct(
        protected OrderStoreAPIRequest $request
    ){
    }

    public function store(){
        // get the products out of request
        $this->convertOrderRequestToModel($this->request->validated('orders'));

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
