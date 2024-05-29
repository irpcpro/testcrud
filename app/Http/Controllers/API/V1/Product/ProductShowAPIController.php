<?php

namespace App\Http\Controllers\API\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\Product\ProductShowFactoryController;
use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use App\Http\Resources\V1\Product\ProductResource;
use App\Models\Product;

class ProductShowAPIController extends Controller {

    public function show(Product $product){
        $getProduct = (new ProductShowFactoryController($product))->show();

        // set response data
        $response = new ResponseFactoryController($getProduct->getStatus(), $getProduct->getMessage(), $getProduct->getData());

        // error on getting products
        if(!$getProduct->getStatus()){
            $response->setStatusCode(400);
            // send response & done
            return response()->json($response->get(), $response->getStatusCode());
        }

        // create resource
        $data = (new ProductResource($response->getData()));

        $response->setData($data);

        // return success
        return response()->json($response->get(),$response->getStatusCode());
    }

}
