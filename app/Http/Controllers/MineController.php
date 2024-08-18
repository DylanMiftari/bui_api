<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartMineRequest;
use App\Models\Mine;
use App\Models\MineLevel;
use App\Models\Resource;
use App\Models\User;
use App\Services\ErrorService;
use App\Services\MineService;
use App\Services\MoneyService;
use App\Services\PlayerResourceService;
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

    public function startMine(StartMineRequest $request, Mine $mine) {
        $user = User::find(Auth::id());
        $resource = Resource::find($request->input("resource_id"));

        if($resource->levelToMine === null || $resource->levelToMine > $mine->level) {
            return $this->errorService->errorResponse("Votre mine ne peut pas miner cette resource", 403);
        }
        if($mine->currentTargetResourceId !== null) {
            return $this->errorService->errorResponse("Votre mine est déjà en cours de minage", 422);
        }

        $this->mineService->startMine($mine, $resource);

        return response()->json([
            "status" => "success",
            "message" => "Le minage a commencé"
        ]);
    }

    public function collectMine(Mine $mine, PlayerResourceService $playerResourceService) {
        if($mine->currentTargetResourceId === null) {
            return $this->errorService->errorResponse("Votre mine ne mine rien, il n'y a rien a collecter", 422);
        }
        if($mine->remainTimeInMinute > 0) {
            return $this->errorService->errorResponse("Votre mine n'a pas terminé son minage, vous ne pouvez rien collecter", 403);
        }

        $user = User::find(Auth::id());
        $resource = Resource::find($mine->currentTargetResourceId);

        if(!$playerResourceService->checkCapacity($user, $resource->mineQuantity)) {
            return $this->errorService->errorResponse("Vous n'avez pas assez de place dans votre inventaire de ressource", 403);
        }

        $playerResourceService->addResource($user, $resource, $resource->mineQuantity);
        $this->mineService->emptyMine($mine);

        return response()->json([
            "status" => "success",
            "message" => "Ressource collectée"
        ]);
    }

    public function upgradeMine(Mine $mine, MoneyService $moneyService) {
        $user = User::find(Auth::id());
        $mineLevel = MineLevel::find($mine->level);

        if($mine->level >= config("mine.maxLevel")) {
            return $this->errorService->errorResponse("Votre mine est déjà au niveau max", 422);
        }

        if(!$moneyService->checkMoney($user, $mineLevel->priceForNextLevel)) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent pour améliorer votre mine, si vous payer avec un compte bancaire, il faut prendre en comtpe les frais de transaction", 422);
        }
        $moneyService->pay($user, $mineLevel->priceForNextLevel, "Amélioration d'une mine au niveau : ".(($mine->level)+1));
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
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent pour acheter une nouvelle mine, si vous payer avec un compte bancaire, il faut prendre en comtpe les frais de transaction", 422);
        }
        $moneyService->pay($user, $this->mineService->getNewMinePrice($user), "Achat d'une nouvelle mine");
        $mine = $this->mineService->createNewMine($user);
        return response()->json([
            "status" => "success",
            "mine" => $mine
        ]);
    }
}
