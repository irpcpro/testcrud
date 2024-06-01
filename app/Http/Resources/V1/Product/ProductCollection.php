<?php

namespace App\Http\Resources\V1\Product;

use App\Http\Resources\V1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection  {

    public function toArray(Request $request) {
        return $this->collection->map(function( $item ){
            return [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'created_at' => $item->created_at,
                'inventory' => $item->inventory,
                'user' => new UserResource($item->user)
            ];
        });
    }
}
