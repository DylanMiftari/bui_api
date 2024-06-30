<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\PlayerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, PlayerService $playerService) {
        $user = $playerService->createUser($request->pseudo, $request->password);
        
        return response()->json([
            "result" => "success",
            "token" => $playerService->getToken($user)
        ]);
    }

    public function login(LoginRequest $request, PlayerService $playerService){
        $user = User::where('pseudo', $request->pseudo)->firstOrFail();

        if(!$playerService->checkPassword($user, $request->password)) {
            return response()->json([
                "result" => "error",
                "error" => "Invalid Credentials"
            ], 401);
        }

        return response()->json([
            "result" => "success",
            "token" => $playerService->getToken($user)
        ]);
    }

    public function logout(){
        return "success";
    }
}
