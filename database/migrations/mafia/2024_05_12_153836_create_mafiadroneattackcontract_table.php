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
        Schema::create('mafiadroneattackcontract', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("mafiaContractId");
            $table->foreign("mafiaContractId")->references("id")->on("mafiacontract")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("playerId")->nullable();
            $table->foreign("playerId")->references("id")->on("player")->nullOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("homeId")->nullable();
            $table->foreign("homeId")->references("id")->on("home")->nullOnDelete()->restrictOnUpdate();

            $table->string("targetType", 10)->comment("player or home");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mafiadroneattackcontract');
    }
};
