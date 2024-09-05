<?php

namespace App\Services;

use App\Models\User;

class MoneyService {

    protected BankAccountService $bankAccountService;

    public function __construct(BankAccountService $bankAccountService) {
        $this->bankAccountService = $bankAccountService;
    }

    public function checkMoney(User $user, float $price): bool {
        $total_money = $this->getTotalMoneyOfPlayer($user);
        $mostExpensiteTransfertCost = $user->bankAccounts()->orderByDesc("transferCost")->first();
        if($mostExpensiteTransfertCost === null) {
            return $total_money >= $price;
        }

        return $total_money >= $price + round($price*$mostExpensiteTransfertCost->transferCost/100, 2);
    }

    public function getTotalMoneyOfPlayer(User $player) {
        return round($player->playerMoney + $this->bankAccountService->getTotalMoneyOfAccount($player), 2);
    }

    public function pay(User $user, float $price, string $description = ""): float {
        $totalPayed = 0;
        $actualPayed = 0;

        // BankAccounts
        $bankAccounts = $user->bankAccounts()->where("isEnable", true)->get()->shuffle();
        foreach($bankAccounts as $bankAccount) {
            if($bankAccount->money >= round($price-$totalPayed, 2)) {
                $actualPayed += $this->bankAccountService->makeTransaction($bankAccount, round($price-$totalPayed, 2), $description);
                return $actualPayed;
            }

            $canPay = $this->bankAccountService->maxCanPay($bankAccount);
            $totalPayed += $canPay;
            $actualPayed += $this->bankAccountService->makeTransaction($bankAccount, $canPay, $description);
        }
        // Player Money
        $actualPayed = round($actualPayed + round($price-$totalPayed, 2));
        $user->playerMoney = round($user->playerMoney - round($price-$totalPayed, 2), 2);
        $user->save();

        return $actualPayed;
    }

    public function canStoreMoney(User $user, float $money): bool {
        $canStore = 0;
        // Bank Accounts
        $bankAccounts = $user->bankAccounts()->where("isEnable", true)->get();
        if(count($bankAccounts) > 0) {
            $canStore += round($bankAccounts->sum('maxMoney') - $bankAccounts->sum("money"), 2);
        }
        // PlayerMoney
        $canStore += $user->storableMoney();
        return $canStore >= $money;
    }

    public function credit(User $user, float $money, string $description = ""): void {
        $totalCredit = 0;
        // Bankaccounts
        $bankAccounts = $user->bankAccounts()->where("isEnable", true)->get()->shuffle();
        foreach($bankAccounts as $bankAccount) {
            if($bankAccount->storableMoney() >= round($money - $totalCredit, 2)) {
                $this->bankAccountService->makeCreditTransaction($bankAccount, round($money - $totalCredit, 2), $description);
                return;
            }
            $canStore = $bankAccount->storableMoney();
            $totalCredit = round($canStore + $totalCredit, 2);
            $this->bankAccountService->makeCreditTransaction($bankAccount, $canStore, $description);
        }
         // User
        $user->playerMoney = round($user->playerMoney + round($money - $totalCredit, 2), 2);
        $user->save();
        return;
    }

}