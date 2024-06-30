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
        Schema::create('banklevel', function (Blueprint $table) {
            $table->unsignedBigInteger("level")->primary();
            $table->unsignedBigInteger("maxMoneyAccount");
            $table->float("maxResourceAccount", total: 15);
            $table->unsignedInteger("maxNbAccount");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banklevel');
    }
};
