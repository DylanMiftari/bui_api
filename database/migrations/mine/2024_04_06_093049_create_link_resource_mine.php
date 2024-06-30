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
        Schema::table("mine", function (Blueprint $table) {
            $table->unsignedBigInteger("currentTargetResourceId")->nullable();
            $table->foreign("currentTargetResourceId")->references("id")->on("resource")->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("mine", function (Blueprint $table) {
            $table->dropForeign(["currentTargetResourceId"]);
            $table->dropColumn("currentTargetResourceId");
        });
    }
};
