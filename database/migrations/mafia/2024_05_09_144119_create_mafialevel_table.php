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
        Schema::create('mafialevel', function (Blueprint $table) {
            $table->unsignedSmallInteger("level")->primary();
            $table->float("playerRobPrice", total: 20);
            $table->float("companyRobPrice", total: 20);
            $table->float("bankAccountRobPrice", total: 20);
            $table->float("homeSafeRobPrice", total: 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mafialevel');
    }
};
