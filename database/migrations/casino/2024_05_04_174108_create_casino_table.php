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
        Schema::create('casino', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("ticketPrice")->default(75);
            $table->unsignedInteger("VIPTicketPrice")->default(7500);

            $table->unsignedSmallInteger("level")->default(1);
            $table->foreign("level")->references("level")->on("casinolevel")->restrictOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("companyId");
            $table->foreign("companyId")->references("id")->on("company")->restrictOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casino');
    }
};
