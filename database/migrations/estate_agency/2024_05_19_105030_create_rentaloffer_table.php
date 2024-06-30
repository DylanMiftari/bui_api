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
        Schema::create('estaterentaloffer', function (Blueprint $table) {
            $table->id();

            $table->float("rent", total: 20);
            $table->float("secondRent", total: 20)->nullable();

            $table->unsignedBigInteger("estateAgencyId");
            $table->foreign("estateAgencyId")->references("id")->on("estateagency")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("playerId")->nullable();
            $table->foreign("playerId")->references("id")->on("player")->nullOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("houseId");
            $table->foreign("houseId")->references("id")->on("house")->restrictOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentaloffer');
    }
};
