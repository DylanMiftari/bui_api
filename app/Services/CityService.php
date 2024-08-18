<?php

namespace App\Services;

use App\Models\City;
use App\Models\User;
use Illuminate\Support\Carbon;

class CityService {

    protected MoneyService $moneyService;

    public function __construct(MoneyService $moneyService) {
        $this->moneyService = $moneyService;
    }

    public function getDetails(): array {
        $res = [];
        foreach(City::all() as $city) {
            $cityArray = $city->toArray();
            $cityArray["nbEntreprises"] = $city->companies()->count();

            array_push($res, $cityArray);
        }

        return $res;
    }

    public function changeCity(User $user, City $destCity) {
        $user->inTravel = true;
        $addDays = config("city.default_travel_time") + config("city.travel_tier_multiplicator") * abs($destCity->rank - $user->city->rank);
        $user->endTravel = Carbon::now()->addDays($addDays);

        $user->city_id = $destCity->id;
        $this->moneyService->pay($user, config("city.change_cost"), "Voyage vers ".$destCity->name);

        $user->save();
    }

    public function endTravel(User $user) {
        $user->inTravel = false;
        $user->save();
    }

}