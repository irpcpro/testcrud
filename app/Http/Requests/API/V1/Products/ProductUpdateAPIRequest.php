<?php

namespace App\Http\Requests\API\V1\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateAPIRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'inventory' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'name is required.',
            'name.string' => 'name should be string.',
            'name.min' => 'name length should not be less than 2 characters.',
            'name.max' => 'name length should not be more than 255 characters.',
            'price.required' => 'price is required.',
            'price.integer' => 'price should be integer.',
            'price.min' => 'price should not be less that 0.',
            'inventory.required' => 'inventory is required.',
            'inventory.integer' => 'inventory should be integer.',
            'inventory.min' => 'inventory should not be less than 0.',
        ];
    }
}
