<?php

namespace App\Http\Controllers\API\V1\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\Order\OrderStoreFactoryController;
use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use App\Http\Requests\API\V1\Order\OrderStoreAPIRequest;
use App\Http\Resources\V1\Order\OrderResource;

class OrderStoreAPIController extends Controller {

    public function store(OrderStoreAPIRequest $request){

        dd($request);

        $order = (new OrderStoreFactoryController($request))->store();

        // set response data
        $response = new ResponseFactoryController($order->getStatus(), $order->getMessage(), $order->getData());

        // error on creating product
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
