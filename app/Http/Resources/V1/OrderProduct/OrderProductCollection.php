<?php

namespace App\Http\Resources\V1\OrderProduct;

use App\Http\Resources\V1\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class OrderProductCollection extends ResourceCollection
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): Collection
    {
        return $this->collection->map(function( $item ){
            return [
                'id' => $item->id,
                'count' => $item->count,
                'price' => $item->price,
                'product' => new ProductResource($item->product)
            ];
        });
    }
}
