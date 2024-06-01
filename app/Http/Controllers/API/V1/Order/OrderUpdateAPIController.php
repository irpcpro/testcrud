<?php

namespace App\Http\Controllers\API\V1\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\Order\OrderUpdateFactoryController;
use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use App\Http\Requests\API\V1\Order\OrderUpdateAPIRequest;
use App\Http\Resources\V1\Order\OrderResource;
use App\Models\Order;

class OrderUpdateAPIController extends Controller {

    public function update(Order $order, OrderUpdateAPIRequest $request){
        $order = (new OrderUpdateFactoryController($order, $request))->update();

        // set response data
        $response = new ResponseFactoryController($order->getStatus(), $order->getMessage(), $order->getData());

        // error on getting order
        if(!$order->getStatus()){
            $response->setStatusCode(400);
            // send response & done
            return response()->json($response->get(), $response->getStatusCode());
        }

        // create resource
        $data = new OrderResource($response->getData());
        $response->setData($data->toArray($request));

        // return success
        return response()->json($response->get(),$response->getStatusCode());
    }

}
