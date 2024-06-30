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
        Schema::create('estatecanconstruct', function (Blueprint $table) {
            $table->unsignedSmallInteger("estateAgencyLevel");
            $table->foreign("estateAgencyLevel")->references("level")->on("estateagencylevel")->restrictOnDelete()->restrictOnUpdate();
            $table->unsignedMediumInteger("houseTypeId");
            $table->foreign("houseTypeId")->references("id")->on("housetype")->restrictOnDelete()->restrictOnUpdate();
            $table->primary(["estateAgencyLevel", "houseTypeId"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estatecanconstruct');
    }
};
