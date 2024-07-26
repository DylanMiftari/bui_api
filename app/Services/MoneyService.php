<?php

namespace App\Services;

use App\Models\User;

class MoneyService {

    public function checkMoney(User $user, float $price): bool {
        return $user->playerMoney >= $price;
    }

    public function pay(User $user, float $price): void {
        $user->playerMoney = round($user->playerMoney - $price, 2);
        $user->save();
    }

    public function canStoreMoney(User $user, float $money): bool {
        return $user->playerMoney + $money <= config("player.max_money");
    }

    public function credit(User $user, float $money): void {
        $user->playerMoney = round($user->playerMoney + $money, 2);
        $user->save();
    }

}