<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Requests\AppRequest;
use Illuminate\Validation\Rules\Password;

class AuthRegisterAPIRequest extends AppRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => ['required', 'string', "min:2", "max:20"],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', Password::min(3)],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'name is required.',
            'name.min' => "name should not be less than :min characters.",
            'name.max' => "name should not be more than :max characters.",
            'email.required' => 'email is required.',
            'email.email' => 'email is not correct.',
            'email.unique' => 'this email is already taken.',
            'password.required' => 'password is required.',
            'password.min' => "password should not be less that :min characters.",
        ];
    }

}
