<?php

namespace App\Services;

use App\Models\Casino;
use App\Models\Company;
use App\Models\User;

class CasinoService extends CompanyService {
    
    public function createCasino(User $user, string $name, int $ticketPrice, float $rouletteSequenceMultiplicator, 
    float $rouletteTripletMultiplicator, float $rouletteTripleSeventMultiplicator, int $rouletteMaxBet): Company {
        $company = parent::createCompany($user, $name, "casino");
        $casino = Casino::create([
            "ticketPrice" => $ticketPrice,
            "companyId" => $company->id,
            "rouletteSequenceMultiplicator" => $rouletteSequenceMultiplicator,
            "rouletteTripletMultiplcator" => $rouletteTripletMultiplicator,
            "rouletteTripleSeventMultiplicator" => $rouletteTripleSeventMultiplicator,
            "rouletteMaxBet" => $rouletteMaxBet
        ]);

        return $company;
    }

    public function updateTicketPrice(Casino $casino, float | null $ticketPrice, float | null $VIPTicketPrice) {
        if($ticketPrice !== null) {
            $casino->ticketPrice = $ticketPrice;
        }
        if($VIPTicketPrice !== null) {
            $casino->VIPTicketPrice = $VIPTicketPrice;
        }
        $casino->save();
    }

}