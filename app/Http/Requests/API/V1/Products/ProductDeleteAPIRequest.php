<?php

namespace App\Http\Requests\API\V1\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductDeleteAPIRequest extends FormRequest {
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
