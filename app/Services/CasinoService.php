<?php

namespace App\Services;

use App\Models\Casino;
use App\Models\CasinoParty;
use App\Models\CasinoTicket;
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

    public function buyTicket(Casino $caisno, User $player, bool $isVIP): CasinoTicket {
        $ticket = new CasinoTicket();
        $ticket->isVIP = $isVIP;
        $ticket->casinoId = $caisno->id;
        $ticket->playerId = $player->id;
        $ticket->save();

        return $ticket;
    }

    public function playRoulette(): string {
        $nb1 = (string)random_int("0", 9);
        $nb2 = (string)random_int("0", 9);
        $nb3 = (string)random_int("0", 9);
        return $nb1.$nb2.$nb3;
    }

    public function roulette(Casino $casino, float $bet): array {
        $res = $this->playRoulette();
        $gain = 0;
        if(in_array($res, [
            "012", "123", "234", "345", "456", "567", "678", "789",
            "210", "321", "432", "543", "654", "765", "876", "987"
        ])) {
            $gain = round($bet * $casino->rouletteSequenceMultiplicator, 2);
        } else if(in_array($res, ["000", "111", "222", "333", "444", "555", "666", "888", "999"])) {
            $gain = round($bet * $casino->rouletteTripletMultiplcator, 2);
        } else if($res === "777") {
            $gain = round($bet * $casino->rouletteTripleSeventMultiplicator, 2);
        }

        return [
            "res" => $res,
            "gain" => $gain
        ];
    }

    public function saveParty(string $gameName, int $bet, int $winnings, Casino $casino, User $user) {
        $casinoParty = new CasinoParty();
        $casinoParty->gameName = $gameName;
        $casinoParty->bet = $bet;
        $casinoParty->winnings = $winnings;
        $casinoParty->casinoId = $casino->id;
        $casinoParty->playerId = $user->id;
        $casinoParty->save();
    }

}