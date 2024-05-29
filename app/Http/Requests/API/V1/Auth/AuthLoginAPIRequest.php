<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Requests\AppRequest;

class AuthLoginAPIRequest extends AppRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function messages(): array {
        return [
            'email.required' => 'email is required.',
            'email.email' => 'email is not correct.',
            'password.required' => 'password is required.',
        ];
    }
}
