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
            $table->unsignedBigInteger("money");
            $table->float("rate", total: 5);

            $table->unsignedBigInteger("playerId");
            $table->foreign("playerId")->references('id')->on("player")->restrictOnDelete()->restrictOnUpdate();
            
            $table->unsignedBigInteger("companyId");
            $table->foreign("companyId")->references("id")->on("company")->restrictOnDelete()->restrictOnUpdate();

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
