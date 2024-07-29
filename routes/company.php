<?php

use App\Http\Controllers\CompanyController;
use App\Http\Middleware\CheckCompanyMiddleware;
use App\Http\Middleware\TravelMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware("auth:sanctum")->group(function() {
    Route::get("/", [CompanyController::class, "index"]);
    Route::get("/{company}", [CompanyController::class, "show"]);
    Route::middleware([TravelMiddleware::class])->group(function() {

        Route::post("/", [CompanyController::class, "createCompany"]);
        
        Route::middleware(CheckCompanyMiddleware::class)->group(function() {
            Route::patch("/upgrade/{company}", [CompanyController::class, "upgrade"]);
        });
    });
});