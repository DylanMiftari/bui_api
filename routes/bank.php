<?php

use App\Http\Controllers\BankController;
use App\Http\Middleware\CheckBankAccountMiddleware;
use App\Http\Middleware\CheckBankClientMiddleware;
use App\Http\Middleware\CheckBankMiddleware;
use App\Http\Middleware\CheckCompanyClientMiddleware;
use App\Http\Middleware\CheckCompanyLevelMiddleware;
use App\Http\Middleware\CheckCompanyMiddleware;
use App\Http\Middleware\CheckHaveBankAccountMiddleware;
use App\Models\Bank;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function() {
    Route::get("/{company}", [BankController::class, "show"])->middleware(CheckCompanyMiddleware::class);
    Route::get("/{bank}/accounts", [BankController::class, "getAccounts"])->middleware(CheckBankMiddleware::class);

    Route::put("/edit/{bank}", [BankController::class, "edit"])->middleware(CheckBankMiddleware::class);

    Route::get("/account/{bankAccount}", [BankController::class, "getAccountTransaction"])->middleware(CheckBankAccountMiddleware::class);

    Route::get("/client/{company}", [BankController::class, "showClient"])->middleware(CheckCompanyClientMiddleware::class);

    Route::prefix("/client/{bank}")->middleware(CheckBankClientMiddleware::class)->group(function() {
        Route::model('bank', Bank::class);
        Route::post("/open-account", [BankController::class, "openAccount"]);
        Route::middleware(CheckHaveBankAccountMiddleware::class)->group(function() {
            Route::patch("/debit", [BankController::class, "debitAccount"]);
            Route::patch("/credit", [BankController::class, "creditAccount"]);
            Route::prefix("/credit-request")->middleware("companyLevel:".config("bank.min_level_for_credit"))->group(function() {
                Route::post("/", [BankController::class, "createCreditRequest"]);
            });
        });
    });
});