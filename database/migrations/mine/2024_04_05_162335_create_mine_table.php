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
        Schema::enableForeignKeyConstraints();
        Schema::create('mine', function (Blueprint $table) {
            $table->id();
            $table->timestamp("startedAt")->nullable();
            $table->unsignedBigInteger("player_id");
            $table->foreign("player_id")->references("id")->on("player")->restrictOnDelete()->restrictOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mine', function (Blueprint $table) {
            $table->dropForeign(['player_id']);
        });
        Schema::dropIfExists('mine');
    }
};
