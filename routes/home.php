<?php

use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckHomeMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function() {
    Route::get("/{home}", [HomeController::class, "show"])->middleware(CheckHomeMiddleware::class);
});