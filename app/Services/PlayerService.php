<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PlayerService {
    
    function createUser(string $pseudo, string $password): User {
        $user = User::create([
            "pseudo" => $pseudo,
            "password" => Hash::make($password)
        ]);
        return $user;
    }

    function getToken(User $user): string {
        $user->tokens()->delete();
        return $user->createToken("auth-token", ["*"], Carbon::now()->addWeek())->plainTextToken;
    }

    function checkPassword(User $user, string $password): bool {
        return Hash::check($password, $user->password);
    }

}