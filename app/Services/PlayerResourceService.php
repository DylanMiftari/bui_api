<?php

namespace App\Services;

use App\Models\PlayerResource;
use App\Models\Resource;
use App\Models\User;

class PlayerResourceService {

    public function getTotalResourceQuantity(User $user): float {
        return PlayerResource::where("player_id", $user->id)->sum("quantity");
    }

    public function checkCapacity(User $user, float $quantity): bool {
        return $this->getTotalResourceQuantity($user) + $quantity <= (float)config("player.max_resource");
    }

    public function addResource(User $user, Resource $resource, float $quantity) {
        $playerResource = PlayerResource::where("player_id", $user->id)->where("resource_id", $resource->id)->first();
        if($playerResource === null) {
            PlayerResource::create([
                "player_id" => $user->id,
                "resource_id" => $resource->id,
                "quantity" => $quantity
            ]);
        } else {
            $playerResource->quantity += $quantity;
            $playerResource->save();
        }
    }

}