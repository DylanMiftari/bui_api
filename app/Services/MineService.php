<?php

namespace App\Services;

use App\Models\Mine;
use App\Models\User;
use Illuminate\Support\Carbon;

class MineService {

    public function getNewMinePrice(User $user): float {
        return config("mine.newMinePrice")[$user->mines()->count() - 1];
    }

    public function createNewMine(User $user): Mine {
        return Mine::create([
            "player_id" => $user->id
        ]);
    }

    public function remainTimeInMintes(Mine $mine): int {
        return Carbon::now()->diffInMinutes(Carbon::createFromFormat("Y-m-d H:i:s", $mine->startedAt));
    }

}