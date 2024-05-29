<?php

namespace App\Http\Controllers\Factories\AuthFactory;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\FactoryConnector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginFactoryController extends Controller {

    public function __construct(
        private Request $request
    ){
    }

    public function login(): FactoryConnector {
        $reponse = new FactoryConnector();
        $status = false;
        $message = '';
        $data = '';

        try {
            // attempt to login
            $login = $this->request->only('email', 'password');
            if (!$token = auth('api')->attempt($login)) {
                $message = 'username or password are wrong.';
            }else{
                $status = true;
                $data = [
                    'user' => Auth::user(),
                    'token' => $token,
                ];
                $message = 'user logged in.';
            }
        }catch (\Exception $exception){
            // set data to pass through the system
            $message = 'error on login.';
            Log::error('error on login user', [$exception->getMessage()]);
        }

        // return result
        $reponse->setStatus($status);
        $reponse->setMessage($message);
        $reponse->setData($data);
        return $reponse;
    }

}
