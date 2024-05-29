<?php

namespace App\Http\Resources\V1\Product;

use App\Http\Resources\V1\User\UserResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function __construct(Product $resource){
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'inventory' => $this->inventory,
            'user' => new UserResource($this->user),
        ];
    }
}
