<?php

namespace App\Http\Controllers\API\V1\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\Order\OrderShowFactoryController;
use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use App\Http\Resources\V1\Order\OrderResource;
use App\Models\Order;

class OrderShowAPIController extends Controller {

    public function show(Order $order){
        $getOrder = (new OrderShowFactoryController($order))->show();

        // set response data
        $response = new ResponseFactoryController($getOrder->getStatus(), $getOrder->getMessage(), $getOrder->getData());

        // error on getting products
        if(!$getOrder->getStatus()){
            $response->setStatusCode(400);
            // send response & done
            return response()->json($response->get(), $response->getStatusCode());
        }

        // create resource
        $data = (new OrderResource($response->getData()));

        $response->setData($data);

        // return success
        return response()->json($response->get(),$response->getStatusCode());
    }

}
