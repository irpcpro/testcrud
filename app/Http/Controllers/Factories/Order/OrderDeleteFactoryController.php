<?php

namespace App\Http\Controllers\Factories\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\Order;
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
//        DB::beginTransaction(); // TODO - db transaction
        try {

            $this->order->syncOrderProducts(collect([]));
            $delete = $this->order->delete();

//            DB::commit();
        }catch (\Exception $exception){
//            DB::rollBack();
            $response->setMessage('error on deleting order.')->setData('')->setStatus(false);
            Log::error('error on deleting order', [$exception->getMessage()]);
            return $response;
        }

        // return result
        $response->setStatus($delete);
        $response->setMessage($delete ? 'order deleted.' : 'error in deleting order.');
        $response->setData([]);
        return $response;
    }

}
