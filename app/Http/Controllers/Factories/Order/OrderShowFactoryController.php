<?php

namespace App\Http\Controllers\Factories\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\Order;

class OrderShowFactoryController extends Controller {

    public function __construct(
        private Order $order
    ){
    }

    public function show(){
        // factory connector
        $response = new FactoryConnector();

        // filter or do anything on product
        $order = $this->order;

        // return result
        $response->setStatus(true);
        $response->setMessage('order received.');
        $response->setData($order);
        return $response;
    }

}
