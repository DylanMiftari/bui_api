<?php

namespace App\Services;

class WithService {

    public function with($query, string | null $with) {
        if($with === null) {
            return $query;
        }
        foreach(explode(",", $with) as $withElement) {
            $query = $query->with($withElement);
        }
        return $query;
    }

}