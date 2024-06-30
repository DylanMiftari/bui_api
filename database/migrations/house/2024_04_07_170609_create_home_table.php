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
        Schema::create('home', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("id_house");
            $table->foreign("id_house")->references("id")->on("house")->restrictOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("id_player")->nullable();
            $table->foreign("id_player")->references("id")->on("player")->restrictOnDelete()->restrictOnUpdate();

            $table->float("moneyInSafe", total: 20)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home');
    }
};
