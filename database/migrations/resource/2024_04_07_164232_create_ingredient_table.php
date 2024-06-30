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
        Schema::create('ingredient', function (Blueprint $table) {
            $table->unsignedBigInteger("id_resource");
            $table->unsignedBigInteger("id_recipe");
            $table->primary(["id_resource", "id_recipe"]);

            $table->float("quantity", total: 15)->comment("in kg");

            $table->foreign("id_resource")->references("id")->on("resource")->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign("id_recipe")->references("id")->on("recipe")->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient');
    }
};
