<?php

use App\Http\Controllers\CasinoController;
use App\Http\Middleware\casino\HaveNoTicketMiddleware;
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
});