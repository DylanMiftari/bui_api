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
        Schema::create('bankaccount', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("accountMaintenanceCost")->comment("Cost for 1 week");
            $table->float("transferCost", total: 5)->comment("in percentage");
            $table->float("money", total: 20)->default(0);
            $table->unsignedBigInteger("maxMoney");
            $table->float("maxResource", total: 15);

            $table->unsignedBigInteger("bankId");
            $table->foreign("bankId")->references("id")->on("bank")->restrictOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("playerId");
            $table->foreign("playerId")->references("id")->on("player")->restrictOnDelete()->restrictOnUpdate();

            $table->boolean("isCredit")->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bankaccount');
    }
};
