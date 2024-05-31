<?php

namespace App\Http\Resources\V1\Order;

use App\Http\Resources\V1\OrderProduct\OrderProductCollection;
use App\Http\Resources\V1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'count' => $this->count,
            'total_price' => $this->total_price,
            'user' => new UserResource($this->user),
            'order_products' => (new OrderProductCollection($this->orderProducts))->toArray($request)
        ];
    }
}
