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
        Schema::create('minelevel', function (Blueprint $table) {
            $table->unsignedTinyInteger("level")->primary();
            $table->unsignedInteger("priceForNextLevel")->nullable();
        });

        Schema::table("mine", function (Blueprint $table) {
            $table->unsignedTinyInteger("level")->default(1);
            $table->foreign("level")->references("level")->on("minelevel")->restrictOnDelete()->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mine', function (Blueprint $table) {
            $table->dropForeign(['level']);
            $table->dropColumn("level");
        });
        Schema::dropIfExists('minelevel');
    }
};
