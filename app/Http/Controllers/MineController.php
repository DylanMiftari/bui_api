<?php

namespace App\Http\Controllers;

use App\Models\Mine;
use App\Models\User;
use App\Services\ErrorService;
use App\Services\MineService;
use App\Services\MoneyService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MineController extends Controller
{
    protected ErrorService $errorService;
    protected MineService $mineService;

    public function __construct(ErrorService $errorService, MineService $mineService) {
        $this->errorService = $errorService;
        $this->mineService = $mineService;
    }

    public function getData(Mine $mine) {
        if($mine->player_id !== Auth::id()) {
            return $this->errorService->errorResponse("Ce n'est pas votre mine", 403);
        }
        $res = $mine->toArray();
        $res["resource"] = $mine->resource;
        $res["remainTimeInMinutes"] = $this->mineService->remainTimeInMintes($mine);

        return $res;
    }

    public function buyNewMine(MoneyService $moneyService) {
        $user = User::find(Auth::id());
        if($user->mines()->count() >= config("player.max_mines")) {
            return $this->errorService->errorResponse("Vous possédez déjà le nombre maximum de mines", 422);
        }
        if(!$moneyService->checkMoney($user, $this->mineService->getNewMinePrice($user))) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent pour acheter une nouvelle mine", 422);
        }
        $moneyService->pay($user, $this->mineService->getNewMinePrice($user));
        $mine = $this->mineService->createNewMine($user);
        return response()->json([
            "status" => "success",
            "mine" => $mine
        ]);
    }
}
