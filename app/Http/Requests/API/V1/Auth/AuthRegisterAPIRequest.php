<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Requests\AppRequest;
use Illuminate\Validation\Rules\Password;

class AuthRegisterAPIRequest extends AppRequest {

    private int $minName = 2;
    private int $maxName = 20;
    private int $minPass = 3;

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => ['required', 'string', "min:$this->minName", "max:$this->maxName"],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', Password::min($this->minPass)],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'name is required.',
            'name.min' => "name should not be less than $this->minName characters.",
            'name.max' => "name should not be more than $this->maxName characters.",
            'email.required' => 'email is required.',
            'email.email' => 'email is not correct.',
            'email.unique' => 'this email is already taken.',
            'password.required' => 'password is required.',
            'password.min' => "password should not be less that $this->minPass characters.",
        ];
    }

}
