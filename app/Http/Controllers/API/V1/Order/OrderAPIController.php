<?php

namespace App\Http\Controllers\API\V1\Order;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\Order\OrderFactoryController;
use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use App\Http\Resources\V1\Order\OrderCollection;
use Illuminate\Http\Request;

class OrderAPIController extends Controller {

    public function index(Request $request){
        $products = (new OrderFactoryController($request))->index();

        // set response data
        $response = new ResponseFactoryController($products->getStatus(), $products->getMessage(), $products->getData());

        // create resource
        $data = (new OrderCollection($response->getData()))->response()->getData();
        $response->setData([
            'products' => $data->data,
            'links' => $data->links,
            'meta' => $data->meta,
        ]);

        // return success
        return response()->json($response->get(),$response->getStatusCode());
    }

}
