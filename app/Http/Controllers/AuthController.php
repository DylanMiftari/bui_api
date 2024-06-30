<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $registerUserData = $request->validate([
            'pseudo'=>'required|string',
            'password'=>'required'
        ]);
        $user = User::create([
            'pseudo' => $registerUserData['pseudo'],
            'password' => Hash::make($registerUserData['password']),
        ]);
        return response()->json([
            'message' => 'User Created ',
        ]);
    }

    public function login(Request $request){
        $loginUserData = $request->validate([
            'pseudo'=>'required|string',
            'password'=>'required'
        ]);
        $user = User::where('pseudo',$loginUserData['pseudo'])->first();
        if(!$user || !Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function logout(){
        return "koukou";
    }
}
