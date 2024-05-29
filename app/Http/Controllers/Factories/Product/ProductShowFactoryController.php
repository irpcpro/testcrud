<?php

namespace App\Http\Controllers\Factories\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\Product;

class ProductShowFactoryController extends Controller {

    public function __construct(
        private Product $product
    ){
    }

    public function show(){
        // factory connector
        $response = new FactoryConnector();

        // filter or do anything on product
        $product = $this->product;

        // return result
        $response->setStatus(true);
        $response->setMessage('product received.');
        $response->setData($product);
        return $response;
    }
}
