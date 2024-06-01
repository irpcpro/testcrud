<?php

namespace App\Http\Controllers\Factories\Order;

use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderUpdateFactoryController extends OrderFactoryController {

    public function __construct(
        private Order $order,
        private Request $request
    ){
    }

    public function update(){
        // get the products out of request
        $this->convertOrderRequestToModel($this->request->validated('orders'));

        // factory connector through the system
        $response = new FactoryConnector();
        $response->setStatus(false)->setMessage('')->setData('');

        $client = DB::getMongoClient();
        $session = $client->startSession();
        $session->startTransaction();
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
            $this->order->update([
                'count' => $orderCount,
                'total_price' => $orderTotalPrice,
            ]);

            // get data and sync the orderProducts
            $orderProducts = $this->createOrderProductsList();

            // sync the order products
            $this->order->syncOrderProducts($orderProducts);

            // ready data and return
            $response->setData($this->order)->setStatus(true)->setMessage('orders have created.');
            $session->commitTransaction();
            return $response;
        }catch (\Exception $exception){
            $session->abortTransaction();
            // set data to pass through the system
            $response->setMessage('error on store order.')->setData('')->setStatus(false);
            Log::error('error on storing order', [$exception->getMessage()]);
            return $response;
        } finally {
            $session->endSession();
        }

    }

}
