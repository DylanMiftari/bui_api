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
        Schema::create('bankaccounttransaction', function (Blueprint $table) {
            $table->id();
            $table->float("money", total: 20);
            $table->string("description", 150)->default("");

            $table->unsignedBigInteger("bankAccountId");
            $table->foreign("bankAccountId")->references("id")->on("bankaccount")->cascadeOnDelete()->cascadeOnUpdate();

            $table->boolean("isCredit")->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bankaccounttransaction');
    }
};
