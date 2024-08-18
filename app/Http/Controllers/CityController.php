<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeCityRequest;
use App\Models\City;
use App\Models\Company;
use App\Models\User;
use App\Services\CityService;
use App\Services\ErrorService;
use App\Services\MoneyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{

    protected ErrorService $errorService;
    protected CityService $cityService;

    public function __construct(ErrorService $errorService, CityService $cityService) {
        $this->errorService = $errorService;
        $this->cityService = $cityService;
    }

    public function index() {
        return $this->cityService->getDetails();
    }

    public function companies() {
        $user = User::find(Auth::id());

        return Company::where("city_id", $user->city_id)->where("activated", 1)->with("user")
            ->orderByDesc("companylevel")->orderByDesc("id")->get();
    }

    public function change(ChangeCityRequest $request, MoneyService $moneyService) {
        $user = User::find(Auth::id());
        $destCity = City::find($request->input("city_id"));

        if(!$moneyService->checkMoney($user, config("city.change_cost"))) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent pour voyager, si vous payer avec un compte bancaire, il faut prendre en comtpe les frais de transaction", 422);
        }
        if($destCity->id === $user->city_id) {
            return $this->errorService->errorResponse("Vous êtes déjà dans cette ville", 422);
        }

        $this->cityService->changeCity($user, $destCity);

        return response()->json([
            "status" => "success"
        ]);
    }
}
