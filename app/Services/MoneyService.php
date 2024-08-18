<?php

namespace App\Services;

use App\Models\User;

class MoneyService {

    protected BankAccountService $bankAccountService;

    public function __construct(BankAccountService $bankAccountService) {
        $this->bankAccountService = $bankAccountService;
    }

    public function checkMoney(User $user, float $price): bool {
        $total_money = $this->bankAccountService->getTotalMoneyOfAccount($user) + $user->playerMoney;
        $mostExpensiteTransfertCost = $user->bankAccounts()->orderByDesc("transferCost")->first();
        if($mostExpensiteTransfertCost === null) {
            return $total_money >= $price;
        }

        return $total_money >= $price + round($price*$mostExpensiteTransfertCost->transferCost/100, 2);
    }

    public function pay(User $user, float $price, string $description = ""): float {
        $totalPayed = 0;
        $actualPayed = 0;

        // Player Money
        if($user->playerMoney >= $price) {
            $user->playerMoney = round($user->playerMoney - $price, 2);
            $user->save();
            return $price;
        }
        $totalPayed = $user->playerMoney;
        $actualPayed = $user->playerMoney;
        $user->playerMoney = 0;
        $user->save();

        // BankAccounts
        $bankAccounts = $user->bankAccounts->shuffle();
        foreach($bankAccounts as $bankAccount) {
            if($bankAccount->money >= round($price-$totalPayed, 2)) {
                $actualPayed += $this->bankAccountService->makeTransaction($bankAccount, round($price-$totalPayed, 2), $description);
                return $actualPayed;
            }

            $canPay = $this->bankAccountService->maxCanPay($bankAccount);
            $totalPayed += $canPay;
            $actualPayed += $this->bankAccountService->makeTransaction($bankAccount, $canPay, $description);
        }

        return $actualPayed;
    }

    public function canStoreMoney(User $user, float $money): bool {
        return $user->playerMoney + $money <= config("player.max_money");
    }

    public function credit(User $user, float $money): void {
        $user->playerMoney = round($user->playerMoney + $money, 2);
        $user->save();
    }

}