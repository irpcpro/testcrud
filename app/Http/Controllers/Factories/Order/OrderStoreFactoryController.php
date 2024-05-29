<?php

namespace App\Http\Controllers\Factories\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\FactoryConnector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderStoreFactoryController extends Controller {

    public function __construct(
        private Request $request
    ){
    }

    public function store(){
        $response = new FactoryConnector();
        $status = false;
        $message = '';
        $data = '';

        try {



            // TODO - here
            // create order
            $order = '';
            // make order & product relation
            // an order =>( can have )=> n product !



            // set data to pass through the system
            $status = true;
            $message = 'product created.';
            $data = $order;
        }catch (\Exception $exception){
            // set data to pass through the system
            $message = 'error on store order.';
            Log::error('error on storing order', [$exception->getMessage()]);
        }

        // return result
        $response->setStatus($status);
        $response->setMessage($message);
        $response->setData($data);
        return $response;
    }

}
