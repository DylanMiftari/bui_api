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
        Schema::create('mafiaphishingcontract', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("mafiaContractId");
            $table->foreign("mafiaContractId")->references("id")->on("mafiacontract")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("bankAccountId")->nullable();
            $table->foreign("bankAccountId")->references("id")->on("bankaccount")->nullOnDelete()->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mafiaphishingcontract');
    }
};
