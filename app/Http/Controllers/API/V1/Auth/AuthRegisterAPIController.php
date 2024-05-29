<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\AuthFactory\AuthRegisterFactoryController;
use App\Http\Controllers\Factories\ResponseFactory\ResponseFactoryController;
use App\Http\Requests\API\V1\Auth\RegisterAPIRequest;
use App\Http\Resources\V1\Auth\UserRegisterResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthRegisterAPIController extends Controller {

    private function createToken(User $user): string | null {
        return auth('api')->login($user) ?? null;
    }

    public function register(RegisterAPIRequest $request){
        // create user
        $user = (new AuthRegisterFactoryController($request))->register();

        // set response data
        $response = new ResponseFactoryController($user->getStatus(), $user->getMessage(), $user->getData());

        // error on creating user
        if(!$user->getStatus()){
            $response->setStatusCode(400);
            // send response & done
            return response()->json($response->get(), $response->getStatusCode());
        }

        // generate token for user
        $_token = $this->createToken($user->getData());
        if($_token == null){
            // set status code and error message
            $response->setStatusCode(500);
            $response->setStatus(false);
            $response->setMessage('user created, but an error occurred in creating token.');
            // insert log
            Log::error('Error on creating user token', [
                'message' => $response->getMessage(),
                'user_id' => $user->getData()->id
            ]);
            // send response & done
            return response()->json($response->get(), $response->getStatusCode());
        }

        $data = new UserRegisterResource($user->getData(), $_token);
        $response->setData($data->toArray($request));

        // return success
        return response()->json($response->get(),$response->getStatusCode());
    }

}
