<?php

namespace App\Services;

use App\Models\User;

class MoneyService {

    public function checkMoney(User $user, float $price): bool {
        return $user->playerMoney >= $price;
    }

    public function pay(User $user, float $price): void {
        $user->playerMoney -= $price;
        $user->save();
    }

}