<?php

use App\Http\Controllers\CityController;
use App\Http\Middleware\TravelMiddleware;
use Illuminate\Support\Facades\Route;

Route::get("/", [CityController::class, "index"]);

Route::middleware("auth:sanctum")->group(function() {
    Route::get("company", [CityController::class, "companies"]);
    Route::patch("change", [CityController::class, "change"])->middleware([TravelMiddleware::class]);
});