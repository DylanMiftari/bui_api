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
        Schema::create('homeresourcesafe', function (Blueprint $table) {
            $table->unsignedBigInteger("id_resource");
            $table->foreign("id_resource")->references("id")->on("resource")->restrictOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger("id_home");
            $table->foreign("id_home")->references("id")->on("home")->restrictOnDelete()->restrictOnUpdate();

            $table->primary(["id_resource", "id_home"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homeresourcesafe');
    }
};
