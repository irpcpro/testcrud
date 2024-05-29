<?php

namespace App\Http\Controllers\API\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\Product\ProductStoreFactoryController;
use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use App\Http\Requests\API\V1\Products\ProductStoreAPIRequest;
use App\Http\Resources\V1\Product\ProductResource;

class ProductStoreAPIController extends Controller {

    public function store(ProductStoreAPIRequest $request){
        $product = (new ProductStoreFactoryController($request))->store();

        // set response data
        $response = new ResponseFactoryController($product->getStatus(), $product->getMessage(), $product->getData());

        // error on creating product
        if(!$product->getStatus()){
            $response->setStatusCode(400);
            // send response & done
            return response()->json($response->get(), $response->getStatusCode());
        }

        // create resource
        $data = new ProductResource($response->getData());
        $response->setData($data->toArray($request));

        // return success
        return response()->json($response->get(),$response->getStatusCode());
    }

}
