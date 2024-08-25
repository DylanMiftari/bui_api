<?php

namespace App\Services;

use App\Models\Resource;
use Illuminate\Support\Arr;

class ResourceService {

    /**
     * Summary of getTotalSell
     * @param array $sellResources ["resource_id" => id, "quantity" => quantity]
     * @return float
     */
    public function getTotalSell(array $sellResources): float {
        return collect($sellResources)->sum(function($e) {
            return $e["quantity"] * Resource::find($e["resource_id"])->marketPrice / 0.1;
        });
    }

    public function getResourcePrice(Resource $resource, float $quantity) {
        return round($quantity * $resource->marketPrice / 0.1, 2);
    }

}