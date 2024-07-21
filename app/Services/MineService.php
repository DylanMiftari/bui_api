<?php

namespace App\Services;

use App\Models\Mine;
use App\Models\Resource;
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

    public function upgradeMine(Mine $mine): void {
        $mine->level++;
        $mine->save();
    }

    public function emptyMine(Mine $mine) {
        $mine->currentTargetResourceId = null;
        $mine->startedAt = null;
        $mine->save();
    }

    public function startMine(Mine $mine, Resource $resource) {
        $mine->currentTargetResourceId = $resource->id;
        $mine->startedAt = Carbon::now();
        $mine->save();
    }

}