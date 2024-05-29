<?php

namespace App\Http\Controllers\Factories\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\Product;

class ProductDeleteFactoryController extends Controller {

    public function __construct(
        private Product $product
    ){
    }

    public function delete(){
        // factory connector
        $response = new FactoryConnector();

        // filter or do anything on product
        $delete = $this->product->delete();

        // return result
        $response->setStatus($delete);
        $response->setMessage($delete ? 'product deleted.' : 'error in deleting product.');
        $response->setData([]);
        return $response;
    }

}
