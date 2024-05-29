<?php

namespace App\Http\Requests\API\V1\Order;

use App\Http\Requests\AppRequest;

class OrderStoreAPIRequest extends AppRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [

        ];
    }

    public function messages(): array {
        return [

        ];
    }
}
