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

    public function updateCreditRequest(CreditRequest $creditRequest, float|null $rate, float|null $money, float|null $weeklyPayments, 
    string|null $description, string|null $status=null) {
        if($rate !== null) {
            $creditRequest->rate = $rate;
        }
        if($money !== null) {
            $creditRequest->money = $money;
        }
        if($weeklyPayments !== null) {
            $creditRequest->weeklypayment = $weeklyPayments;
        }
        if($description !== null && $description !== "") {
            $creditRequest->description = $creditRequest->description."\n-------------\n".$description;
        }
        if($status !== null && $description !== "") {
            $creditRequest->status = $status;
        }
        $creditRequest->save();
    }

}