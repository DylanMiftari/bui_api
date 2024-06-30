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
        Schema::table("resource", function(Blueprint $table) {
            $table->unsignedTinyInteger("levelToMine")->nullable();
            $table->foreign("levelToMine")->references("level")->on("minelevel")->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("resource", function (Blueprint $table) {
            $table->dropForeign(["levelToMine"]);
            $table->dropColumn("levelToMine");
        });
    }
};
