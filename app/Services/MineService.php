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

}