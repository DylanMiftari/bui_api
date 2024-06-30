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
        Schema::create('factoryproductionhistory', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("machineId");
            $table->foreign("machineId")->references("id")->on("factorymachine")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("recipeId");
            $table->foreign("recipeId")->references("id")->on("recipe")->restrictOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factoryproductionhistory');
    }
};
