<?php

namespace App\Http\Requests\API\V1\Order;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateAPIRequest extends FormRequest {
    public function authorize(): bool {
        $orderUserID = $this->route('order')->user_id;
        return $this->user()->id === $orderUserID;
    }

    public function rules(): array {
        $model = new Product();
        return [
            'orders.*.product_id' => ['required', 'exists:'.$model->getTable().',' . $model->getKeyName()],
            'orders.*.count' => ['required', 'integer', 'min:1']
        ];
    }

    public function messages(): array {
        return [
            '*.product_id.required' => 'product IDs are required.',
            '*.product_id.exists' => 'product IDs do not exists.',
            '*.count.required' => 'count is required.',
            '*.count.integer' => 'count should be an integer.',
            '*.count.min' => 'Count must be at least :min.',
        ];
    }
}
