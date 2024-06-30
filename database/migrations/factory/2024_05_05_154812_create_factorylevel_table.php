<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('factorylevel', function (Blueprint $table) {
            $table->unsignedSmallInteger("level")->primary();
            $table->unsignedInteger("nbMachine");
            $table->unsignedInteger("nbSellSlot");
            $table->float("quantityPerSlot", total: 15)->comment("in kg");
            $table->unsignedInteger("warehouseCapacity")->comment("in kg");
            $table->float("distanceSellingMultiplicator", total: 5)->nullable()->comment("null = can't make distance selling");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factorylevel');
    }
};
