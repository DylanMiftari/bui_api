<?php

namespace App\Http\Controllers;

use App\Http\Requests\sellResourceRequest;
use App\Models\PlayerResource;
use App\Models\Resource;
use App\Models\User;
use App\Services\ErrorService;
use App\Services\MoneyService;
use App\Services\PlayerResourceService;
use App\Services\ResourceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    protected ResourceService $resourceService;
    protected ErrorService $errorService;

    public function __construct(ResourceService $resourceService, ErrorService $errorService) {
        $this->resourceService = $resourceService;
        $this->errorService = $errorService;
    }

    public function index() {
        return Resource::all();
    }
    public function playerResources(PlayerResourceService $playerResourceService) {
        $user = User::find(Auth::id());
        
        return $playerResourceService->getAllResources($user);
    }

    public function sell(sellResourceRequest $request, MoneyService $moneyService) {
        dd("a refaire avec les banques");
        $user = User::find(Auth::id());
        $sellResources = $request->input("sell_resources");
        $totalSell = $this->resourceService->getTotalSell($sellResources);
        if(!$moneyService->canStoreMoney($user, $totalSell)) {
            return $this->errorService->errorResponse("Vous ne pourrez pas stocker l'argent de vos ventes", 422);
        }

        /*
        If a user enters resources he doesn't own in the API request body, they will be taken into account in the previous calculations. 
        This is why we re-total the real sales
        */
        $realTotalSell = 0;
        foreach($sellResources as $sellRes) {
            $playerResource = PlayerResource::where("player_id", $user->id)->where("resource_id", $sellRes["resource_id"])->first();

            if($playerResource !== null && $playerResource->quantity >= $sellRes["quantity"]) {
                // Edit DB
                $playerResource->quantity = round($playerResource->quantity - $sellRes["quantity"], 2);
                if($playerResource->quantity == 0) {
                    $playerResource->delete();
                } else {
                    $playerResource->save();
                }
                // Calcul money
                $realTotalSell = round($realTotalSell + $sellRes["quantity"] * Resource::find($sellRes["resource_id"])->marketPrice / 0.1, 2);
            }
        }

        $moneyService->credit($user, $realTotalSell);

        return response()->json([
            "status" => "success",
            "total_sell" => $realTotalSell
        ]);
    }
}
