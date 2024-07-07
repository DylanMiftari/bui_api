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
        Schema::table("home", function(Blueprint $table) {
            $table->unsignedBigInteger("renterId")->nullable();
            $table->foreign("renterId")->references("id")->on("player")->restrictOnDelete()->restrictOnUpdate();
            $table->float("rent", total: 20)->nullable()->comment("weekly");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("home", function(Blueprint $table) {
            $table->dropForeign("renterId");
        });
    }
};
