<?php

use App\Http\Controllers\MineController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function() {
    Route::get("/{mine}", [MineController::class, "getData"]);
    Route::post("/buy", [MineController::class, "buyNewMine"]);
});