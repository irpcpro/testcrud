<?php

namespace App\Http\Controllers\Factories\Product;

use App\Http\Controllers\Factories\Cache\CacheFactoryController;
use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductUpdateFactoryController extends ProductFactoryController {


    public function __construct(
        private Product $product,
        private Request $request
    ){
    }

    public function update(){
        $response = new FactoryConnector();
        $status = false;
        $message = '';
        $data = '';

        try {
            // filter or do anything on product
            $this->product->update([
                'name' => $this->request->validated('name'),
                'price' => $this->request->validated('price'),
                'inventory' => $this->request->validated('inventory'),
            ]);

            // set data to pass through the system
            $status = true;
            $message = 'product updated.';
            $data = $this->product->refresh();

            // remove cache and save this
            CacheFactoryController::remove(Product::CACH_EPREFIX_KEY . $data->id);
        }catch (\Exception $exception){
            // set data to pass through the system
            $message = 'error on updating product.';
            Log::error('error on updating product', [$exception->getMessage()]);
        }

        // return result
        $response->setStatus($status);
        $response->setMessage($message);
        $response->setData($data);
        return $response;
    }

}
