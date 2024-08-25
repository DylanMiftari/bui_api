<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\User;
use App\Services\BankAccountService;
use App\Services\PlayerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function me(PlayerService $playerService, BankAccountService $bankAccountService) {
        $player = User::find(Auth::id());

        $playerService->beforeLoginCheck($player);

        $res = [
            "player" => $player,
            "companies" => $player->companies,
            "has_full_companies" => count($player->companies) >= config("player.max_companies"),
            "mines" => $player->mines,
            "has_full_mines" => count($player->mines) >= config("player.max_mines"),
            "city" => $player->city,
            "homes" => $player->homesInCity(),
            "total_money" => $player->playerMoney + $bankAccountService->getTotalMoneyOfAccount($player),
        ];

        return $res;
    }

    public function bankAccounts(Request $request) {
        $user = User::find(Auth::id());
        $bankAccounts = $user->bankAccounts()->with("bankResourceAccount")->get();
        if($request->input("with") === "companyId") {
            foreach($bankAccounts as $bankAccount) {
                $bankAccount->companyId = $bankAccount->bank->idCompany;
            }
        }

        return $bankAccounts;
    }
}
