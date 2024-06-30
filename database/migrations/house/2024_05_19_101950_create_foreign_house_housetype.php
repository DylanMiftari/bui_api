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
        Schema::table("house", function(Blueprint $table) {
            $table->unsignedMediumInteger("houseTypeId");
            $table->foreign("houseTypeId")->references("id")->on("housetype")->restrictOnDelete()->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("house", function(Blueprint $table) {
            $table->dropForeign("houseTypeId");
        });
    }
};
