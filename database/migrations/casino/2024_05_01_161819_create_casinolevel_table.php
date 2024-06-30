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
        Schema::create('casinolevel', function (Blueprint $table) {
            $table->unsignedSmallInteger("level")->primary();
            $table->unsignedInteger("nbMaxTicket")->nullable()->comment("null = no limit");
            $table->unsignedInteger("nbMaxVIPTicket")->nullable()->comment('null = no limiy');
            $table->unsignedInteger("maxTicketPrice")->nullable()->comment("null = not buyable");
            $table->unsignedInteger("maxVIPTicketPrice")->nullable()->comment("null = not buyable");
            $table->unsignedInteger("maxSuiteRent")->nullable()->comment("weekly | null = not rentable");
            $table->unsignedInteger("nbMaxSuite")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casinolevel');
    }
};
