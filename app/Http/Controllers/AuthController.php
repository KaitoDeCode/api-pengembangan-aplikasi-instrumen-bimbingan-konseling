<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestLogin;
use App\Http\Requests\RequestRegister;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(RequestLogin $request){

    }

    public function register(RequestRegister $request){
        $data = $request->validated();
        $user = User::create([
            "name" => $data["name"],
            "email"=> $data["email"],
            "password"=> bcrypt($data["password"]),
        ]);
        return response()->json([
            "success"=> true,
            "message" => "success register",
        ], 200);
    }
}
