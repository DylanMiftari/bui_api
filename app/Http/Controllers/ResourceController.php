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

    public function sell(sellResourceRequest $request, MoneyService $moneyService, PlayerResourceService $playerResourceService) {
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
            $resource = Resource::find($sellRes["resource_id"]);
            if($playerResourceService->playerHasResource($user, $resource, $sellRes["quantity"])) {
                $price = $this->resourceService->getResourcePrice($resource, $sellRes["quantity"]);
                $realTotalSell = round($realTotalSell + $price, 2);
                $playerResourceService->removeResource($user, $resource, $sellRes["quantity"]);
            }
        }

        $moneyService->credit($user, $realTotalSell, "Ventes de ressources");

        return response()->json([
            "status" => "success",
            "total_sell" => $realTotalSell
        ]);
    }
}
