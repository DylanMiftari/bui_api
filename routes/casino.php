<?php

use App\Http\Controllers\CasinoController;
use App\Http\Middleware\CheckCasinoMiddleware;
use App\Http\Middleware\CheckCompanyMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware("auth:sanctum")->group(function() {
    Route::get("{company}", [CasinoController::class, "show"])->middleware(CheckCompanyMiddleware::class);

    Route::patch("{casino}/tickets", [CasinoController::class, "update"])->middleware(CheckCasinoMiddleware::class);
});