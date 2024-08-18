<?php

namespace App\Services;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Company;
use App\Models\User;

class BankService extends CompanyService {

    public function createBank(User $user, string $name, int $accountMaintenanceCost,
    float $transferCost, int $maxAccountMoney, int $maxAccountResource): Company {
        $company = parent::createCompany($user, $name, "bank");
        $bank = Bank::create([
            "accountMaintenanceCost" => $accountMaintenanceCost,
            "transferCost" => $transferCost,
            "maxAccountMoney" => $maxAccountMoney,
            "maxAccountResource" => $maxAccountResource,
            "idCompany" => $company->id
        ]);

        return $company;
    }

    public function editBank(Bank $bank, float $accountMaintenanceCost, float $transferCost, float $maxAccountMoney,
    float $maxAccountResource) {
        $bank->accountMaintenanceCost = $accountMaintenanceCost;
        $bank->transferCost = $transferCost;
        $bank->maxAccountMoney = $maxAccountMoney;
        $bank->maxAccountResource = $maxAccountResource;
        $bank->save();
    }

    public function openAccount(Bank $bank, User $player) {
        $account = BankAccount::create([
            "accountMaintenanceCost" => $bank->accountMaintenanceCost,
            "transferCost" => $bank->transferCost,
            "maxMoney" => $bank->maxAccountMoney,
            "maxResource" => $bank->maxAccountResource,
            "bankId" => $bank->id,
            "playerId" => $player->id,
        ]);
        return $account;
    }

}