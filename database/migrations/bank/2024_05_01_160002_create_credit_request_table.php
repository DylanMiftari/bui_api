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
        Schema::create('creditrequest', function (Blueprint $table) {
            $table->id();
            $table->string("status", 25);
            $table->float("money", total: 20);
            $table->float("weeklypayment", total: 20);
            $table->float("alreadyPayed", total:20)->default(0);
            $table->float("rate", total: 5)->nullable();
            $table->text("description");

            $table->unsignedBigInteger("playerId");
            $table->foreign("playerId")->references('id')->on("player")->restrictOnDelete()->restrictOnUpdate();
            
            $table->unsignedBigInteger("bankId");
            $table->foreign("bankId")->references("id")->on("bank")->restrictOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creditrequest');
    }
};
