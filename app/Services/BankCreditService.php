<?php

namespace App\Services;

use App\Models\Bank;
use App\Models\CreditRequest;
use App\Models\User;

class BankCreditService {

    public function createCreditRequest(float $money, User $player, Bank $bank, string $description, float $weeklypayment) {
        return CreditRequest::create([
            "status" => "wait on bank",
            "money" => $money,
            "playerId" => $player->id,
            "bankId" => $bank->id,
            "description" => $description,
            "weeklypayment" => $weeklypayment
        ]);
    }

}