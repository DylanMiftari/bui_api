<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('player', function (Blueprint $table) {
            $table->id();
            $table->string("pseudo", length: 100);
            $table->string("password", length: 60);
            $table->float("playerMoney", total: 20)->default(0);
            $table->integer("city_id", unsigned: true)->default(1)->nullable();
            $table->foreign("city_id")->references("id")->on("city")->restrictOnDelete()->restrictOnUpdate();
            $table->string("remember_token", 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('player', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
        });
        Schema::dropIfExists('player');
    }
};
