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
        Schema::table("company", function(Blueprint $table) {
            $table->unsignedTinyInteger("companylevel")->default("1");
            $table->foreign("companylevel")->references("level")->on("companylevel")->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("company", function(Blueprint $table) {
            $table->dropForeign(["companylevel"]);
        });
    }
};
