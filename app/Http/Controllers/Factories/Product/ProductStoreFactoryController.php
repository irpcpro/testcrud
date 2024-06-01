<?php

namespace App\Http\Controllers\Factories\Product;

use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductStoreFactoryController extends ProductFactoryController {

    public function __construct(
        private Request $request
    ){
    }

    public function store(){
        $response = new FactoryConnector();
        $status = false;
        $message = '';
        $data = '';

        try {
            // create user
            $product = Product::create([
                'user_id' => auth()->user()->id,
                'name' => $this->request->validated('name'),
                'price' => $this->request->validated('price'),
                'inventory' => $this->request->validated('inventory'),
            ]);

            // set data to pass through the system
            $status = true;
            $message = 'product created.';
            $data = $product;
        }catch (\Exception $exception){
            // set data to pass through the system
            $message = 'error on store product.';
            Log::error('error on storing product', [$exception->getMessage()]);
        }

        // return result
        $response->setStatus($status);
        $response->setMessage($message);
        $response->setData($data);
        return $response;
    }

}
