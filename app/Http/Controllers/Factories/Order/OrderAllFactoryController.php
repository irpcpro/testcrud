<?php

namespace App\Http\Controllers\Factories\Order;

use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAllFactoryController extends OrderFactoryController {

    public function __construct(
        private Request $request
    ){
    }

    public function index(int $paginate = 10){
        // factory connector
        $response = new FactoryConnector();

        // get products
        $orderKey = (new Order())->getKeyName();
        $products = auth()->user()->orders()->orderBy($orderKey, 'desc')->simplePaginate($paginate);

        // return result
        $response->setStatus(true);
        $response->setMessage('products received.');
        $response->setData($products);
        return $response;
    }

}
