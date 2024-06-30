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
        Schema::create('factorysellslot', function (Blueprint $table) {
            $table->id();

            $table->float("sellPrice", total: 20);
            $table->float("quantity", total: 15)->comment("in kg");
            $table->string("state", 10);

            $table->unsignedBigInteger("resourceId");
            $table->foreign("resourceId")->references("id")->on("resource")->restrictOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("factoryId");
            $table->foreign("factoryId")->references("id")->on("factory")->cascadeOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factorysellslot');
    }
};
