<?php

use App\Http\Controllers\BankController;
use App\Http\Middleware\CheckBankMiddleware;
use App\Http\Middleware\CheckCompanyMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function() {
    Route::get("/{company}", [BankController::class, "show"])->middleware(CheckCompanyMiddleware::class);
    Route::put("/edit/{bank}", [BankController::class, "edit"])->middleware(CheckBankMiddleware::class);
});