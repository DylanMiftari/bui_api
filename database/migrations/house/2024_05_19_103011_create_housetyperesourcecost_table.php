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
        Schema::create('housetyperesourcecost', function (Blueprint $table) {
            $table->unsignedMediumInteger("houseTypeId");
            $table->foreign("houseTypeId")->references("id")->on("housetype")->restrictOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("resourceId");
            $table->foreign("resourceId")->references("id")->on("resource")->restrictOnDelete()->restrictOnUpdate();

            $table->primary(["houseTypeId", "resourceId"]);

            $table->float("quantity", total: 15)->comment("in kg");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housetyperesourcecost');
    }
};
