<?php

namespace App\Http\Controllers\Factories\AuthFactory;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterFactoryController extends Controller {

    public function __construct(
        private Request $request
    ){
    }

    public function register(): FactoryConnector {
        $reponse = new FactoryConnector();
        $status = false;
        $message = '';
        $data = [];

        try {
            // create user
            $user = User::create([
                'name' => $this->request->validated('name'),
                'email' => $this->request->validated('email'),
                'password' => $this->request->validated('password'),
            ]);

            // set data to pass through the system
            $status = true;
            $message = 'user created.';
            $data = $user;
        }catch (\Exception $exception){
            // set data to pass through the system
            $message = 'an error occurred while creating user.';
            Log::error('error on creating user', [$exception->getMessage()]);
        }

        // return result
        $reponse->setStatus($status);
        $reponse->setMessage($message);
        $reponse->setData($data);
        return $reponse;
    }

}
