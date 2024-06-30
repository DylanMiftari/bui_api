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
        Schema::table('casinolevel', function (Blueprint $table) {
            // Roulette (level 1+)
            $table->unsignedBigInteger("rouletteMaxBet")->nullable()->comment("null = casino not have this game");
            $table->unsignedBigInteger("rouletteMaxVIPBet")->nullable()->comment("null = casino not have this game");
            $table->unsignedBigInteger("rouletteMaxUltraVIPBet")->nullable()->comment("null = casino not have this game");

            // Dice (level 2+)
            $table->unsignedBigInteger("diceMaxBet")->nullable()->comment("null = casino not have this game");
            $table->unsignedBigInteger("diceMaxVIPBet")->nullable()->comment("null = casino not have this game");
            $table->unsignedBigInteger("diceMaxUltraVIPBet")->nullable()->comment("null = casino not have this game");

            // Poker (level 3+)
            $table->unsignedBigInteger("pokerMaxBet")->nullable()->comment("null = casino not have this game");
            $table->unsignedBigInteger("pokerMaxVIPBet")->nullable()->comment("null = casino not have this game");
            $table->unsignedBigInteger("pokerMaxUltraVIPBet")->nullable()->comment("null = casino not have this game");

            // Black Jack (level 4+)
            $table->unsignedBigInteger("blackJackMaxBet")->nullable()->comment("null = casino not have this game");
            $table->unsignedBigInteger("blackJackMaxVIPBet")->nullable()->comment("null = casino not have this game");
            $table->unsignedBigInteger("blackJackMaxUltraVIPBet")->nullable()->comment("null = casino not have this game");

            // Roulette 2 (level 5+)
            $table->unsignedBigInteger("roulette2MaxBet")->nullable()->comment("null = casino not have this game");
            $table->unsignedBigInteger("roulette2MaxVIPBet")->nullable()->comment("null = casino not have this game");
            $table->unsignedBigInteger("roulette2MaxUltraVIPBet")->nullable()->comment("null = casino not have this game");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
