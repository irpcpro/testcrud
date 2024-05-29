<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\AuthFactory\AuthLoginFactoryController;
use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use App\Http\Requests\API\V1\Auth\AuthLoginAPIRequest;
use App\Http\Resources\V1\Auth\AuthLoginResource;

class AuthLoginAPIController extends Controller {

    public function login(AuthLoginAPIRequest $request){
        // check user for login
        $login = (new AuthLoginFactoryController($request))->login();

        // set response data
        $response = new ResponseFactoryController($login->getStatus(), $login->getMessage(), $login->getData());

        // error on login user
        if(!$login->getStatus()){
            $response->setStatusCode(401);
            // send response & done
            return response()->json($response->get(), $response->getStatusCode());
        }

        $data = new AuthLoginResource(
            $login->getData()['user'],
            $login->getData()['token']
        );
        $response->setData($data->toArray($request));

        // return success
        return response()->json($response->get(),$response->getStatusCode());
    }

}
