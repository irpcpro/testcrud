<?php

namespace App\Http\Controllers\API\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\Product\ProductDeleteFactoryController;
use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use App\Http\Requests\API\V1\Products\ProductDeleteAPIRequest;
use App\Models\Product;

class ProductDeleteAPIController extends Controller {

    public function delete(Product $product, ProductDeleteAPIRequest $request){
        $delete = (new ProductDeleteFactoryController($product))->delete();

        // set response data
        $response = new ResponseFactoryController($delete->getStatus(), $delete->getMessage(), $delete->getData());

        // error on getting products
        if(!$delete->getStatus()){
            $response->setStatusCode(400);
            // send response & done
            return response()->json($response->get(), $response->getStatusCode());
        }

        // return response
        return response()->json($response->get(), $response->getStatusCode());
    }

}
