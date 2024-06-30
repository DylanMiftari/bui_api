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
        Schema::create('casinoticket', function (Blueprint $table) {
            $table->id();

            $table->boolean("isVIP");

            $table->unsignedBigInteger("casinoId");
            $table->foreign("casinoId")->references("id")->on("casino")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("playerId")->nullable();
            $table->foreign("playerId")->references("id")->on("player")->nullOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casinoticket');
    }
};
