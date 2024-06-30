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
        Schema::create('casinosuite', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("rent")->comment("weekly");

            $table->unsignedBigInteger("casinoId");
            $table->foreign("casinoId")->references("id")->on("casino")->restrictOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("playerId")->nullable();
            $table->foreign("playerId")->references("id")->on("player")->nullOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casinosuite');
    }
};
