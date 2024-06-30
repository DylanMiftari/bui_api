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
        Schema::create('factoryresourcesearch', function (Blueprint $table) {
            $table->id();

            $table->float("price", total: 20);
            $table->float("secondPrice", total: 20)->nullable()->default(null);

            $table->float("quantity", total: 15)->comment("in kg");

            $table->string("state", 10);

            $table->unsignedBigInteger("factoryId");
            $table->foreign("factoryId")->references("id")->on("factory")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("resourceId");
            $table->foreign("resourceId")->references("id")->on("resource")->restrictOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("playerId")->nullable()->default(null);
            $table->foreign("playerId")->references("id")->on("player")->nullOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factoryresourcesearch');
    }
};
