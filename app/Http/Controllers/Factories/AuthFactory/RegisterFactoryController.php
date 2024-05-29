<?php

namespace App\Http\Controllers\Factories\AuthFactory;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factories\FactoryConnector;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use MongoDB\Client;

class RegisterFactoryController extends Controller {

    public function __construct(
        private Request $request
    ){
    }

    public function register(): FactoryConnector {
        // create user
        $user = User::create([
            'name' => $this->request->validated('name'),
            'email' => $this->request->validated('email'),
            'password' => $this->request->validated('password'),
        ]);



        dd($user);

        // set data to pass through the system
        $data = new FactoryConnector();
        $data->setStatus(true);
        $data->setMessage('user created.');
        $data->setData($user);
        return $data;
    }

}
