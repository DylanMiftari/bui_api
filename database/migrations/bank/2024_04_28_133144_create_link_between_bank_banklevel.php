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
        Schema::table("bank", function(Blueprint $table) {
            $table->unsignedBigInteger("level")->default(1);
            $table->foreign("level")->references("level")->on("banklevel")->restrictOnDelete()->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("bank", function(Blueprint $table) {
            $table->dropForeign(["level"]);
        });
    }
};
