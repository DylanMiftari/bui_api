<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function me() {
        $player = Auth::user();
        $res = [
            "player" => $player,
            "companies" => $player->companies,
            "has_full_companies" => count($player->companies) >= config("player.max_companies"),
            "mines" => $player->mines,
            "has_full_mines" => count($player->mines) >= config("player.max_mines"),
        ];

        return $res;
    }
}
