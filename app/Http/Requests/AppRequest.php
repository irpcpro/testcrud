<?php

namespace App\Http\Requests;

use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AppRequest extends FormRequest
{
    public string $error_message = 'Error in input values.';
    public int $error_code = 422;

    public string $error_message_authorization = 'error in request authorization.some validation on inputs are prevented to execute of request.';
    public int $error_code_authorization = 403;

    protected function failedValidation(Validator $validator) {
        $data = [];
        if(!empty($validator->errors())){
            $data = [
                'errors' => $validator->errors()
            ];
        }
        $response = new ResponseFactoryController(false, $this->error_message, $data, $this->error_code);

        throw new HttpResponseException(
            response()->json($response->get(), $this->error_code)
        );
    }

    protected function failedAuthorization() {
        throw new AuthorizationException($this->error_message_authorization, $this->error_code_authorization);
    }

}
