<?php

use App\Http\Controllers\CompanyController;
use App\Http\Middleware\TravelMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware("auth:sanctum")->group(function() {
    Route::get("/", [CompanyController::class, "index"]);
    Route::post("/", [CompanyController::class, "createCompany"])->middleware([TravelMiddleware::class]);
});