<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestLogin;
use App\Http\Requests\RequestRegister;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(RequestLogin $request){
        $data = $request->validated();
        $user = User::where('email',$data['email'])->first();
        if($user && Hash::check($data['password'],$user->password)){
            return response()->json([
                "success"=> false,
                "message" => "invalid credentials",
            ], 404);
        }
        $token = $user->createToken('access-token')->plainTextToken;

        return response()->json([
            "success"=> true,
            "message" => "success login",
            "access-token" => $token,
        ], 200);
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
