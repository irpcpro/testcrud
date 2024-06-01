<?php

namespace App\Http\Controllers\Factories\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderDeleteFactoryController extends Controller {

    public function __construct(
        private Order $order
    ){
    }

    public function delete(){
        // factory connector
        $response = new FactoryConnector();

        // filter or do anything on order
        $client = DB::getMongoClient();
        $session = $client->startSession();
        $session->startTransaction();
        try {
            $this->order->syncOrderProducts(collect([]));
            $delete = $this->order->delete();

            $session->commitTransaction();
        }catch (\Exception $exception){
            $session->abortTransaction();
            $response->setMessage('error on deleting order.')->setData('')->setStatus(false);
            Log::error('error on deleting order', [$exception->getMessage()]);
            return $response;
        } finally {
            $session->endSession();
        }

        // return result
        $response->setStatus($delete);
        $response->setMessage($delete ? 'order deleted.' : 'error in deleting order.');
        $response->setData([]);
        return $response;
    }

}
