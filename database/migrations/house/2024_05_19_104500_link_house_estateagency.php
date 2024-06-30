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
            $table->unsignedBigInteger("estateAgencyId")->nullable();
            $table->foreign("estateAgencyId")->references("id")->on("estateagency")->restrictOnDelete()->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("house", function(Blueprint $table) {
            $table->dropForeign("estateAgencyId");
        });
    }
};
