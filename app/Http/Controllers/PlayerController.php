<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PlayerService;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function me(PlayerService $playerService) {
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
        ];

        return $res;
    }
}
