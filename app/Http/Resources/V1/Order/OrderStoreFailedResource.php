<?php

namespace App\Http\Resources\V1\Order;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderStoreFailedResource extends JsonResource {
    public function __construct(Product $resource){
        parent::__construct($resource);
    }

    public function toArray(Request $request): array{
        return [
            'product_id' => $this->id,
            'product_inventory' => $this->inventory,
            'message' => "the inventory of product '".$this->name."' is less than order count",
        ];
    }
}
