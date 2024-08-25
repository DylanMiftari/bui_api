<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group(function() {
    Route::get("bank-accounts", [PlayerController::class, "bankAccounts"]);
});