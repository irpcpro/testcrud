<?php

namespace App\Http\Controllers\Factories\Product;

use App\Enums\ProductInventoryActionEnum;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductFactoryController extends Controller {

    /**
     * Update inventory of product
     *
     * @param mixed $product
     * @param int $count
     * @param ProductInventoryActionEnum $type ('increase' or 'decrease').
     *
     * @return void
     */
    public static function updateInventory(mixed $product, int $count, ProductInventoryActionEnum $type){
        if(!($product instanceof Product)){
            $productIDKey = (new Product())->getKeyName();
            $product = Product::where($productIDKey,$product)->first();
        }

        switch ($type) {
            case ProductInventoryActionEnum::DECREASE:
                $product->inventory -= $count;
                break;
            case ProductInventoryActionEnum::INCREASE:
                $product->inventory += $count;
                break;
        }

        $product->save();
    }

}
