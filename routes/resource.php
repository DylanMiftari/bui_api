<?php

use App\Http\Controllers\ResourceController;
use App\Http\Middleware\TravelMiddleware;
use Illuminate\Support\Facades\Route;


Route::get("/", [ResourceController::class, "index"]);

Route::middleware("auth:sanctum")->group(function() {
    Route::get("/player", [ResourceController::class, "playerResources"]);
    Route::patch("/sell", [ResourceController::class, "sell"])->middleware([TravelMiddleware::class]);
});