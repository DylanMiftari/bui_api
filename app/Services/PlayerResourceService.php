<?php

namespace App\Services;

use App\Models\PlayerResource;
use App\Models\Resource;
use App\Models\User;

class PlayerResourceService {

    public function getAllResources(User $user) {
        $resources = $user->resourceWithQuantity();
        $resources = $resources->keyBy("name");

        foreach($user->bankAccounts()->where("isEnable", true)->get() as $bankAccount) {
            foreach($bankAccount->resourcesWithQuantity() as $resource) {
                if($resources->has($resource->name)) {
                    $resources[$resource->name]->quantity = round($resources[$resource->name]->quantity + $resource->quantity, 2);
                } else {
                    $resources->put($resource->name, $resource);
                }
            }
        }

        return $resources;
    }

    public function playerHasResource(User $player, Resource $resource, float $quantity) {
        $allResources = $this->getAllResources($player);
        return $allResources->has($resource->name) && $allResources[$resource->name]->quantity >= $quantity;
    }

    public function getTotalResourceQuantity(User $user): float {
        return PlayerResource::where("player_id", $user->id)->sum("quantity");
    }

    public function checkCapacity(User $user, float $quantity): bool {
        $totalStorable = 0;
        // Player
        $totalStorable = round($totalStorable + $user->storableResources(), 2);
        // BankAccount
        foreach($user->bankAccounts()->where("isEnable", true)->get() as $bankAccount) {
            $totalStorable = round($totalStorable + $bankAccount->storableResources(), 2);
        }
        return $totalStorable >= $quantity;
    }

    public function addResource(User $user, Resource $resource, float $quantity) {
        $totalAdded = 0;
        // Player
        if($user->storableResources() >= $quantity) {
            $user->addResource($resource->id, $quantity);
            return;
        }
        $totalAdded = $user->storableResources();
        $user->addResource($resource->id, $totalAdded);
        // BankAccounts
        $bankAccounts = $user->bankAccounts()->where("isEnable", true)->get()->shuffle();
        foreach($bankAccounts as $bankAccount) {
            if($bankAccount->storableResources() >= round($quantity - $totalAdded, 2)) {
                $bankAccount->addResource($resource->id, round($quantity - $totalAdded, 2));
                return;
            }
            $canStore = $bankAccount->storableResources();
            $bankAccount->addResource($resource->id, $canStore);
            $totalAdded = round($totalAdded + $canStore, 2);
        }
        return;
    }

    public function removeResource(User $user, Resource $resource, float $quantity) {
        $totalRemoved = 0;
        // Player
        if($user->resourceQuantity($resource) >= $quantity) {
            $user->removeResource($resource, $quantity);
            return;
        } else if($user->resourceQuantity($resource) > 0) {
            $totalRemoved = $user->resourceQuantity($resource);
            $user->removeResource($resource, $totalRemoved);
        }
        // Bank Accounts
        $bankAccounts = $user->bankAccounts()->where("isEnable", true)->get()->shuffle();
        foreach($bankAccounts as $bankAccount) {
            if($bankAccount->resourceQuantity($resource) >= round($quantity - $totalRemoved, 2)) {
                $bankAccount->removeResource($resource, round($quantity - $totalRemoved, 2));
                return;
            } else if($bankAccount->resourceQuantity($resource) > 0) {
                $canRemove = $bankAccount->resourceQuantity($resource);
                $bankAccount->removeResource($resource, $canRemove);
                $totalRemoved = round($totalRemoved + $canRemove, 2);
            }
        }
        return;
    }

}