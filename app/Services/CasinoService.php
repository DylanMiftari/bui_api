<?php

namespace App\Services;

use App\Class\Card;
use App\Class\CardPack;
use App\Helper\PokerHelper;
use App\Models\Casino;
use App\Models\CasinoParty;
use App\Models\CasinoTicket;
use App\Models\Company;
use App\Models\User;

class CasinoService extends CompanyService {

    public function __construct(protected MoneyService $moneyService, protected CompanyService $companyService) {
    }
    
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
        $nb1 = (string)random_int(0, 9);
        $nb2 = (string)random_int(0, 9);
        $nb3 = (string)random_int(0, 9);
        return $nb1.$nb2.$nb3;
    }

    public function playDice(): int {
        $nb1 = random_int(1, 6);
        $nb2 = random_int(1, 6);

        return $nb1 + $nb2;
    }

    public function playPoker(): array {
        $cards = [];
        $cardPack = new CardPack();

        for($i = 0; $i < 5; $i++) {
            $cards[] = $cardPack->drawCard();
        }

        $cards[0] = new Card(1, 1);
        $cards[1] = new Card(1, 1);
        $cards[2] = new Card(1, 1);
        $cards[3] = new Card(1, 4);
        $cards[4] = new Card(1, 1);

        return $cards;
    }

    
    public function checkBet(int $bet, int $maxBet, int $maxVIPBet, bool $isVIP): bool {
        return (!$isVIP && $bet <= $maxBet) || ($isVIP && $bet <= $maxVIPBet);
    }

    public function playerPayGame(User $user, int $bet, string $gameName, Casino $casino): int {
        $totalPay = $this->moneyService->pay($user, $bet, "Jeu $gameName au casino ".$casino->company->name);
        $this->companyService->storeInSafe($casino->company, $bet);

        return $totalPay;
    }

    public function payGain(User $user, int $gain, Casino $casino, string $gameName) {
        if($this->moneyService->canStoreMoney($user, $gain)) {
            if($casino->company->money_in_safe < $gain) {
                return -1;
            }
            $this->moneyService->credit($user, $gain, "Victoire au jeu $gameName au casino : ".$casino->company->name);
            $this->companyService->removeFromSafe($casino->company, $gain);
            return 0;
        } else {
            return -2;
        }
    }

    public function roulette(Casino $casino, float $bet, bool $isVip): array {
        $res = $this->playRoulette();
        $gain = 0;
        if(in_array($res, [
            "012", "123", "234", "345", "456", "567", "678", "789",
            "210", "321", "432", "543", "654", "765", "876", "987"
        ])) {
            $coef = $isVip ? $casino->rouletteVIPSequenceMultiplicator : $casino->rouletteSequenceMultiplicator;
            $gain = round($bet * $coef, 2);
        } else if(in_array($res, ["000", "111", "222", "333", "444", "555", "666", "888", "999"])) {
            $coef = $isVip ? $casino->rouletteVIPTripletMultiplcator : $casino->rouletteTripletMultiplcator;
            $gain = round($bet * $coef, 2);
        } else if($res === "777") {
            $coef = $isVip ? $casino->rouletteVIPTripleSeventMultiplicator : $casino->rouletteTripleSeventMultiplicator;
            $gain = round($bet * $coef, 2);
        }

        return [
            "res" => $res,
            "gain" => $gain
        ];
    }

    public function dice(Casino $casino, float $bet, bool $isVip): array {
        $res = $this->playDice();
        $gain = 0;
        $goal = $isVip ? $casino->diceVIPGoal : $casino->diceGoal;
        $coef = $isVip ? $casino->diceVIPWinMultiplicator : $casino->diceWinMultiplicator;

        if($res === $goal) {
            $gain = round($bet * $coef, 2);
        }

        return [
            "res" => $res,
            "gain" => $gain
        ];
    }

    public function poker(Casino $casino, float $bet, bool $isVip): array {
        $res = $this->playPoker();
        dump($res);
        dd(PokerHelper::checkFourOfKind($res));

        return [];
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