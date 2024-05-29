<?php

namespace App\Http\Controllers\Factories\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductFactoryController extends Controller {

    public function __construct(
        private Request $request
    ){
    }

    public function index(int $paginate = 10){
        // factory connector
        $response = new FactoryConnector();

        // get products
        $products = Product::simplePaginate($paginate);

        // return result
        $response->setStatus(true);
        $response->setMessage('products received.');
        $response->setData($products);
        return $response;
    }

}
