<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\BankAccountTransaction;
use App\Models\User;

class BankAccountService {

    /**
     * Remove money from account
     */
    public function debitAccount(BankAccount $bankAccount, User $player, float $money) {
        $bankAccount->money -= $bankAccount->costWithTransfertCost($money);
        $bankAccount->save();

        BankAccountTransaction::create([
            "money" => $money,
            "description" => "Retrait d'argent",
            "bankAccountId" => $bankAccount->id,
            "transfert_cost" => $bankAccount->costWithTransfertCost($money) - $money,
            "isCredit" => false,
        ]);

        $player->playerMoney += $money;
        $player->save();
    }

    /**
     * Add money from account
     */
    public function creditAccount(BankAccount $bankAccount, User $player, float $money) {
        $bankAccount->money = round($bankAccount->money + $money, 2);
        $bankAccount->save();

        BankAccountTransaction::create([
            "money" => $money,
            "description" => "Dépôt d'argent",
            "bankAccountId" => $bankAccount->id,
            "transfert_cost" => 0,
            "isCredit" => true,
        ]);

        $player->playerMoney = round($player->playerMoney - $money, 2);
        $player->save();
    }

    public function getTotalMoneyOfAccount(User $player): float {
        return $player->bankAccounts()->sum("money");
    }

    public function makeTransaction(BankAccount $bankAccount, float $price, string $description = ""): float {
        $transactionPrice = round($price * $bankAccount->transferCost / 100, 2);

        $bankAccount->money = round($bankAccount->money - ($price + $transactionPrice), 2);
        $bankAccount->save();

        $bankAccount->bank->company->money_in_safe = round($bankAccount->bank->company->money_in_safe + $transactionPrice, 2);
        $bankAccount->bank->company->save();

        BankAccountTransaction::create([
            "money" => $price,
            "description" => $description,
            "bankAccountId" => $bankAccount->id,
            "transfert_cost" => $transactionPrice,
            "isCredit" => false,
        ]);

        return round($transactionPrice + $price, 2);
    }

    /**
     * Add money on Account
     */
    public function makeCreditTransaction(BankAccount $bankAccount, float $money, string $description = "") {
        $bankAccount->money = round($bankAccount->money + $money, 2);
        $bankAccount->save();

        BankAccountTransaction::create([
            "money" => $money,
            "description" => $description,
            "bankAccountId" => $bankAccount->id,
            "transfert_cost" => 0,
            "isCredit" => 1,
        ]);
    }

    public function maxCanPay(BankAccount $bankAccount): float {
        return floor(
            ($bankAccount->money * 100) /
            (100 + $bankAccount->transferCost)
        );
    }
    
}