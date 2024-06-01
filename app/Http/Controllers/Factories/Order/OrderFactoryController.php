<?php

namespace App\Http\Controllers\Factories\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Order\OrderStoreFailedResource;
use App\Models\Product;
use Illuminate\Support\Collection;

class OrderFactoryController extends Controller {

    /**
     * @var Collection $orders
     * @var Product $product
     * @var int $count
     */
    protected Collection $orders;

    /** @var OrderStoreFailedResource[] $errorCountOrders */
    protected array $errorCountOrders = [];

    // convert order to product
    protected function convertOrderRequestToModel($orderRequest){
        // get all products
        $orders = collect($orderRequest);
        $productIDs = $orders->pluck('product_id');
        $products = new Product();
        $products = $products::whereIn($products->getKeyName(), $productIDs)->get();

        // make the array of orders with models and count
        $this->orders = $products->map(function($item) use ($orders) {
            return [
                'product' => $item,
                'count' => $orders->firstWhere('product_id', $item->id)['count'],
            ];
        });
    }

    // check the count of purchase
    protected function validateCountOrders(): void{
        $this->orders->map(function($item){
            if($item['count'] > $item['product']->inventory){
                $this->errorCountOrders[] = (new OrderStoreFailedResource($item['product']))->toArray($this->request);
            }
        });
    }

    protected function calculateOrderTotalPrice(): int {
        return $this->orders->sum(fn($item) => $item['product']->price * $item['count']);
    }

    protected function calculateOrderCount(): int {
        return $this->orders->sum('count');
    }

    protected function createOrderProductsList(): Collection {
        return $this->orders->mapWithKeys(function($item) {
            return [
                $item['product']->id => [
                    'count' => $item['count'],
                    'price' => $item['product']->price,
                    'product' => $item['product'],
                ]
            ];
        });
    }

}
