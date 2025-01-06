<?php

use App\Http\Controllers\CasinoController;
use App\Http\Middleware\casino\CasinoClientMiddleware;
use App\Http\Middleware\casino\HaveNoTicketMiddleware;
use App\Http\Middleware\casino\HaveTicketMiddleware;
use App\Http\Middleware\CheckCasinoMiddleware;
use App\Http\Middleware\CheckCompanyClientMiddleware;
use App\Http\Middleware\CheckCompanyMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware("auth:sanctum")->group(function() {
    Route::get("{company}", [CasinoController::class, "show"])->middleware(CheckCompanyMiddleware::class);

    Route::patch("{casino}/tickets", [CasinoController::class, "update"])->middleware(CheckCasinoMiddleware::class);

    Route::prefix("/client/{company}")->middleware(CheckCompanyClientMiddleware::class)->group(function() {
        Route::get("", [CasinoController::class, "showClient"]);

        Route::post("/{casino}/buy-ticket", [CasinoController::class, "buyTicket"])->middleware(HaveNoTicketMiddleware::class);
    });

    Route::get("/casino/{casino}", [CasinoController::class, "showClientCasino"]);

    Route::prefix("{casino}/game")->middleware([CasinoClientMiddleware::class, HaveTicketMiddleware::class])->group(function () {
        Route::post("/roulette", [CasinoController::class, "playRoulette"]);
        Route::post("/dice", [CasinoController::class, "playDice"])
            ->middleware(["checkCasinoLevel:".config("casino.min_level_for_dice")]);
        Route::post("/poker", [CasinoController::class, "playPoker"])
            ->middleware(["checkCasinoLevel:".config("casino.min_level_for_poker")]);
    });
});