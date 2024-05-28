<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterAPIRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => ['required', 'string', 'min:2', 'max:20'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', Password::min(3)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '',
            'name.min' => '',
            'name.max' => '',
            'email.required' => '',
            'email.email' => '',
            'email.unique' => '',
            'password.required' => '',
            'password.min' => '',
        ];
    }

}
