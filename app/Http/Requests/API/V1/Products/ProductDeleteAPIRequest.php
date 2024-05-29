<?php

namespace App\Http\Requests\API\V1\Products;

use App\Http\Requests\AppRequest;

class ProductDeleteAPIRequest extends AppRequest
{

    public function authorize(): bool {
        $productUserID = $this->route('product')->user_id;
        return $this->user()->id === $productUserID;
    }

}
