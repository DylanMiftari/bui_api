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
        Schema::create('mafiacontract', function (Blueprint $table) {
            $table->id();

            $table->float("clientPrice", total: 20);
            $table->float("secondPrice", total: 20)->nullable()->default(null);

            $table->dateTime("robDate")->nullable()->default(null);
            $table->string("robState", 10);
            $table->string("robType", 25);


            $table->unsignedBigInteger("playerId");
            $table->foreign("playerId")->references("id")->on("player")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("mafiaId");
            $table->foreign("mafiaId")->references("id")->on("mafia")->cascadeOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mafiacontract');
    }
};
