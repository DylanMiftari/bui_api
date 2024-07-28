<?php

use App\Http\Controllers\MineController;
use App\Http\Middleware\CheckMineMiddleware;
use App\Http\Middleware\TravelMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(["auth:sanctum"])->group(function() {
    Route::get("/{mine}", [MineController::class, "getData"])->middleware([CheckMineMiddleware::class]);
    Route::middleware([TravelMiddleware::class])->group(function() {
        Route::post("/buy", [MineController::class, "buyNewMine"]);
        Route::post("/{mine}/upgrade", [MineController::class, "upgradeMine"])->middleware([CheckMineMiddleware::class]);
        Route::post("/{mine}/collect", [MineController::class, "collectMine"])->middleware([CheckMineMiddleware::class]);
        Route::post("/{mine}/start", [MineController::class, "startMine"])->middleware([CheckMineMiddleware::class]);
    });
});