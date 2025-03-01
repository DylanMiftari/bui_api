<?php

namespace App\Services;

use App\Models\House;
use App\Models\User;
use App\Models\Home;
use App\Models\Mine;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PlayerService {

    protected CityService $cityService;

    public function __construct(CityService $cityService) {
        $this->cityService = $cityService;
    }
    
    function createUser(string $pseudo, string $password): User {
        $user = User::create([
            "pseudo" => $pseudo,
            "password" => Hash::make($password)
        ]);
        $mine = Mine::create([
            "player_id" => $user->id
        ]);
        $house = House::create([
            "houseTypeId" => 1 // Tipi houseType id
        ]);
        $home = Home::create([
            "id_house" => $house->id,
            "id_player" => $user->id,
            "rent" => config("house.default_house_type_1_rent")
        ]);
        return $user;
    }

    function getToken(User $user): string {
        $user->tokens()->delete();
        return $user->createToken("auth-token", ["*"], Carbon::now()->addWeek())->plainTextToken;
    }

    function checkPassword(User $user, string $password): bool {
        return Hash::check($password, $user->password);
    }

    function noPayTaxes(User $user): void {
        $user->city_id = 1;
        $user->save();
    }

    // Check et potentielle modification à faire quand le joueur se connecte
    function beforeLoginCheck(User $user): void {
        if(Carbon::now() >= $user->endTravel) {
            $this->cityService->endTravel($user);
        }
    }

}