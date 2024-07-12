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
        Schema::create('factorymachine', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("factoryId");
            $table->foreign("factoryId")->references("id")->on("factory")->restrictOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("currentRecipeId")->nullable();
            $table->foreign("currentRecipeId")->references("id")->on("recipe")->restrictOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factorymachine');
    }
};
