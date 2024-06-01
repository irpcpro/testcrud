<?php

namespace App\Http\Controllers\API\V1\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\Order\OrderDeleteFactoryController;
use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderDeleteAPIController extends Controller {

    public function delete(Request $request, Order $order){
        $delete = (new OrderDeleteFactoryController($order))->delete();

        // set response data
        $response = new ResponseFactoryController($delete->getStatus(), $delete->getMessage(), $delete->getData());

        // error on getting order
        if(!$delete->getStatus()){
            $response->setStatusCode(400);
            // send response & done
            return response()->json($response->get(), $response->getStatusCode());
        }

        // return response
        return response()->json($response->get(), $response->getStatusCode());
    }

}
