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
        Schema::create('playerresource', function (Blueprint $table) {
            $table->unsignedBigInteger("player_id");
            $table->unsignedBigInteger("resource_id");
            $table->float("quantity", total: 15)->comment("in kg");
            $table->primary(["player_id", "resource_id"]);

            // A player cannot own more than 35kg of resources, all resources combined. But this will be checked in PHP
            $table->foreign("player_id")->references("id")->on("player")->restrictOnDelete()->restrictOnUpdate();
            $table->foreign("resource_id")->references("id")->on("resource")->restrictOnDelete()->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playerresource');
    }
};
