<?php

namespace App\Http\Controllers;

use App\Http\Requests\casino\BuyTicketRequest;
use App\Http\Requests\casino\DiceRequest;
use App\Http\Requests\casino\PokerRequest;
use App\Http\Requests\casino\RouletteRequest;
use App\Http\Requests\UpdateCasinoRequest;
use App\Models\Casino;
use App\Models\Company;
use App\Models\User;
use App\Services\CasinoService;
use App\Services\CompanyService;
use App\Services\ErrorService;
use App\Services\MoneyService;
use App\Services\WithService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CasinoController extends Controller
{
    protected ErrorService $errorService;
    protected WithService $withService;

    protected CasinoService $casinoService;

    public function __construct(ErrorService $errorService, WithService $withService, CasinoService $casinoService, private MoneyService $moneyService, 
    private CompanyService $companyService) {
        $this->errorService = $errorService;
        $this->withService = $withService;
        $this->casinoService = $casinoService;
    }

    public function show(Request $request, Company $company) {
        if($company->company_type !== "casino") {
            return $this->errorService->errorResponse("L'entreprise n'est pas un casino", 422);
        }
        return $this->withService->with(Casino::where("companyId", $company->id), $request->input("with"))->first();
    }

    public function showClient(Company $company) {
        if($company->company_type !== "casino") {
            return $this->errorService->errorResponse("L'entreprise n'est pas un casino", 422);
        }
        $user = User::find(Auth::id());
        $res = [
            "casino" => $company->casino,
            "ticket" => $user->casinoTicket($company->casino)
        ];
        $res["casino"]["ticketCount"] = $company->casino->ticketsCount();
        $res["casino"]["casinolevel"] = $company->casino->casinolevel;
        $res["casino"]["VIPTicketCount"] = $company->casino->VIPTicketsCount();
        return $res;
    }

    public function showClientCasino(Casino $casino) {
        return $this->showClient($casino->company);
    }

    public function update(UpdateCasinoRequest $request, Casino $casino) {
        $casinoLevel = $casino->casinolevel;
        $ticketPrice = $request->input("ticketPrice");
        $VIPTicketPrice = $request->input("VIPTicketPrice");

        if($ticketPrice !== null && $ticketPrice > $casinoLevel->maxTicketPrice) {
            return $this->errorService->errorResponse("Pour un casino de niveau ".$casinoLevel->level." le prix maximal du ticket est de ".$casinoLevel->maxTicketPrice, 422);
        }
        if($ticketPrice !== null && $VIPTicketPrice > $casinoLevel->maxVIPTicketPrice) {
            return $this->errorService->errorResponse("Pour un casino de niveau ".$casinoLevel->level." le prix maximal du ticket VIP est de ".$casinoLevel->maxVIPTicketPrice, 422);
        }

        $this->casinoService->updateTicketPrice($casino, $ticketPrice, $VIPTicketPrice);

        return response()->json([
            "status" => "success"
        ]);
    }

    public function buyTicket(BuyTicketRequest $request, Company $company, Casino $casino, MoneyService $moneyService) {
        $ticketCount = $casino->ticketsCount();
        $VIPTicketCount = $casino->VIPTicketsCount();
        $isVIP = $request->input("isVIP", false);
        $user = User::find(Auth::id());

        $ticketPrice = $isVIP ? $casino->VIPTicketPrice : $casino->ticketPrice;

        if(!$isVIP && $ticketCount+1 > $casino->casinolevel->nbMaxTicket) {
            return $this->errorService->errorResponse("Ce casino a vendu tous ses tickets", 403);
        }
        if($isVIP && $casino->level < config("casino.min_level_to_sell_vip_tickets")) {
            return $this->errorService->errorResponse("Ce casino ne vend pas de ticket VIP", 422);
        }
        if($isVIP && $VIPTicketCount+1 > $casino->casinolevel->nbMaxVIPTicket) {
            return $this->errorService->errorResponse("Ce casino a vendu tous ses tickets VIP", 403);
        }
        if(!$moneyService->checkMoney($user, $ticketPrice)) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent pour acheter un ticket", 403);
        }

        $ticket = $this->casinoService->buyTicket($casino, $user, $isVIP);

        $ticketName = $isVIP ? "ticket VIP" : "ticket";
        $casinoName = $casino->company->name;
        $moneyService->pay($user, $ticketPrice, "Achat d'un $ticketName au casino $casinoName");

        return response()->json([
            "status" => "success",
            "ticket" => $ticket
        ]);
    }

    public function playRoulette(RouletteRequest $request, Casino $casino) {
        $bet = $request->input("bet");
        $user = User::find(Auth::id());
        $isVIP = $user->vipCasinoTicket($casino) !== null;
        $maxBet = $casino->rouletteMaxBet;
        $maxVIPBet = $casino->rouletteMaxVIPBet;

        if(!$this->casinoService->checkBet($bet, $maxBet, $maxVIPBet, $isVIP)) {
            return $this->errorService->errorResponse("Votre mise doit être inférieur à ".$casino->rouletteMaxBet, 422);
        }
        if(!$this->moneyService->checkMoney($user, $bet)) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent pour jouer cette mise", 422);
        }

        // Paiement
        $totalPay = $this->casinoService->playerPayGame($user, $bet, "roulette", $casino);

        // Partie
        $res = $this->casinoService->roulette($casino, $bet, $isVIP);
        $this->casinoService->saveParty("roulette", $bet, $res["gain"], $casino, $user);

        // Gain
        if($res["gain"] !== 0) {
            $r = $this->casinoService->payGain($user, $res["gain"], $casino, "roulette");
            switch($r) {
                case -1:
                    return $this->errorService->errorResponse("Vous avez gagné ".$res["gain"]." mais le casino ne possède pas assez d'argent pour payer", 400);
                case -2;
                    return $this->errorService->errorResponse("Vous avez gagné ".$res["gain"]." mais vous ne pouvez pas stocker cette somme d'argent", 400);
            }
        }

        $res["pay"] = $totalPay;

        return $res;
    }

    public function playDice(DiceRequest $request, Casino $casino) {
        $bet = $request->input("bet");
        $user = User::find(Auth::id());
        $isVIP = $user->vipCasinoTicket($casino) !== null;
        $maxBet = $casino->diceMaxBet;
        $maxVIPBet = $casino->diceVIPMaxBet;

        if(!$this->casinoService->checkBet($bet, $maxBet, $maxVIPBet, $isVIP)) {
            return $this->errorService->errorResponse("Votre mise doit être inférieur à ".($isVIP ? $maxVIPBet : $maxBet), 422);
        }
        if(!$this->moneyService->checkMoney($user, $bet)) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent pour jouer cette mise", 422);
        }

        // Paiement
        $totalPay = $this->casinoService->playerPayGame($user, $bet, "dé", $casino);

        // Partie
        $res = $this->casinoService->dice($casino, $bet, $isVIP);
        $this->casinoService->saveParty("dé", $bet, $res["gain"], $casino, $user);

        // Gain
        if($res["gain"] !== 0) {
            $r = $this->casinoService->payGain($user, $res["gain"], $casino, "dé");
            switch($r) {
                case -1:
                    return $this->errorService->errorResponse("Vous avez gagné ".$res["gain"]." mais le casino ne possède pas assez d'argent pour payer", 400);
                case -2;
                    return $this->errorService->errorResponse("Vous avez gagné ".$res["gain"]." mais vous ne pouvez pas stocker cette somme d'argent", 400);
            }
        }

        $res["pay"] = $totalPay;

        return $res;
    }

    public function playPoker(PokerRequest $request, Casino $casino) {
        $bet = $request->input("bet");
        $user = User::find(Auth::id());
        $isVIP = $user->vipCasinoTicket($casino) !== null;
        $maxBet = $casino->pokerMaxBet;
        $maxVIPBet = $casino->pokerMaxVIPBet;

        if(!$this->casinoService->checkBet($bet, $maxBet, $maxVIPBet, $isVIP)) {
            return $this->errorService->errorResponse("Votre mise doit être inférieur à ".($isVIP ? $maxVIPBet : $maxBet), 422);
        }
        if(!$this->moneyService->checkMoney($user, $bet)) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent pour jouer cette mise", 422);
        }

        // Paiement
        $totalPay = $this->casinoService->playerPayGame($user, $bet, "solo poker", $casino);

        // Partie
        $res = $this->casinoService->poker($casino, $bet, $isVIP);
        $this->casinoService->saveParty("solo poker", $bet, $res["gain"], $casino, $user);

        // Gain
        if($res["gain"] != 0) {
            $r = $this->casinoService->payGain($user, $res["gain"], $casino, "solo poker");
            switch($r) {
                case -1:
                    return $this->errorService->errorResponse("Vous avez gagné ".$res["gain"]." mais le casino ne possède pas assez d'argent pour payer", 400);
                case -2;
                    return $this->errorService->errorResponse("Vous avez gagné ".$res["gain"]." mais vous ne pouvez pas stocker cette somme d'argent", 400);
            }
        }

        $res["pay"] = $totalPay;

        return $res;
    }
}
