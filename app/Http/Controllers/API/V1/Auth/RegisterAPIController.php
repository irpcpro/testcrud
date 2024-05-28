<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAPIRequest;

class RegisterAPIController extends Controller {

    public function register(RegisterAPIRequest $request){
        echo 'hello22';
    }

}
