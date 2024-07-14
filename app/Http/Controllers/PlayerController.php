<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function me() {
        $player = Auth::user();
        $res = [
            "player" => $player,
            "companies" => $player->companies,
            "has_full_companies" => count($player->companies) >= config("player.max_companies")
        ];

        return $res;
    }
}