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
        Schema::create('bank', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("accountMaintenanceCost")->default(1000)->comment("Cost for 1 week");
            $table->float("transferCost", total: 5)->default(0.02)->comment("in percentage");
            $table->unsignedBigInteger("maxAccountMoney")->default(50_000);
            $table->float("maxAccountResource", total: 15)->default(10.0)->comment("in kg");
            $table->unsignedBigInteger("idCompany");
            $table->foreign("idCompany")->references("id")->on("company")->restrictOnDelete()->restrictOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank');
    }
};
