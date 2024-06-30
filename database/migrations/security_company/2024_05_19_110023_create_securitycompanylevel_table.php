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
        Schema::create('securitycompanylevel', function (Blueprint $table) {
            $table->unsignedSmallInteger("level")->primary();
            $table->float("resourceSafeCapacity", total: 15)->comment("in kg");

            $table->boolean("hasAlarm");
            $table->boolean("hasPepperSpray");
            $table->boolean("hasGasDispenser");
            $table->boolean("hasReinforcedDoor");
            $table->boolean("hasBodyGuard");
            $table->boolean("hasSecurityGuard");
            $table->boolean("hasCyberDefense");
            $table->boolean("hasAntiAISystem");
            $table->boolean("hasContainmentSystem");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('securitycompanylevel');
    }
};
