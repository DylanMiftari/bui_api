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
        Schema::create('housetype', function (Blueprint $table) {
            $table->unsignedMediumInteger("id")->primary();
            $table->string("typeName", 50)->unique();
            $table->unsignedInteger("constructionDuration")->comment("in days");
            $table->float("constructionCost", total: 20)->comment("money");
            $table->float("maintenanceCost", total: 20)->comment("weekly");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housetype');
    }
};
