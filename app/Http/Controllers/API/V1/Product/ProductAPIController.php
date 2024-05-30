<?php

namespace App\Http\Controllers\API\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\Product\ProductFactoryController;
use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\V1\Product\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductAPIController extends Controller {

    public function index(Request $request){
        $products = (new ProductFactoryController($request))->index();

        // set response data
        $response = new ResponseFactoryController($products->getStatus(), $products->getMessage(), $products->getData());

        // error on getting products
        if(!$products->getStatus()){
            $response->setStatusCode(400);
            // send response & done
            return response()->json($response->get(), $response->getStatusCode());
        }

        // create resource
        $data = (new ProductCollection($response->getData()))->response()->getData();

        $response->setData([
            'products' => $data->data,
            'links' => $data->links,
            'meta' => $data->meta,
        ]);

        // return success
        return response()->json($response->get(),$response->getStatusCode());
    }

}
