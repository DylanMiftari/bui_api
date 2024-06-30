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
        Schema::create('recipe', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->primary();
            $table->unsignedInteger("creationTime")->comment("in minute");
            $table->float("createdQuantity", total: 15)->comment("in kg");
            $table->unsignedBigInteger("createdResourceId");
            $table->foreign("createdResourceId")->references("id")->on("resource")->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("recipe", function(Blueprint $table) {
            $table->dropForeign(["createdResourceId"]);
        });
        Schema::dropIfExists('recipe');
    }
};
