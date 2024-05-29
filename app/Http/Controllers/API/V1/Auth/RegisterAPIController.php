<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\AuthFactory\RegisterFactoryController;
use App\Http\Requests\API\V1\Auth\RegisterAPIRequest;

class RegisterAPIController extends Controller {

    public function register(RegisterAPIRequest $request){
        $data = (new RegisterFactoryController($request))->register();
        dd($data->getData(), 22);
    }

}
