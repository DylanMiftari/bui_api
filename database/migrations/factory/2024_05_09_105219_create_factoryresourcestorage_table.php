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
        Schema::create('factoryresourcestorage', function (Blueprint $table) {
            $table->unsignedBigInteger("factoryId");
            $table->foreign("factoryId")->references("id")->on("factory")->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger("resourceId");
            $table->foreign("resourceId")->references("id")->on("resource")->restrictOnDelete()->restrictOnUpdate();
            $table->primary(["factoryId", "resourceId"]);

            $table->float("quantity", total: 15)->comment("in kg");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factoryresourcestorage');
    }
};
