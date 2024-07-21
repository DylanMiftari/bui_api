<?php

namespace App\Http\Controllers;

use App\Models\Mine;
use App\Models\MineLevel;
use App\Models\Resource;
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
        $res = $mine->toArray();
        
        $res["mineable_resources"] = Resource::where("levelToMine", "<=", $res["level"])->get();

        return $res;
    }

    public function upgradeMine(Mine $mine, MoneyService $moneyService) {
        $user = User::find(Auth::id());
        $mineLevel = MineLevel::find($mine->level);

        if(!$moneyService->checkMoney($user, $mineLevel->priceForNextLevel)) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent pour améliorer votre mine", 422);
        }
        $moneyService->pay($user, $mineLevel->priceForNextLevel);
        $this->mineService->upgradeMine($mine);

        return response()->json([
            "status" => "success",
            "mine" => $mine
        ]);
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
