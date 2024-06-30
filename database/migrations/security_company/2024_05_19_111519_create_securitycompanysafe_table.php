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
        Schema::create('securitycompanysafe', function (Blueprint $table) {
            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securitycompany")->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger("resourceId");
            $table->foreign("resourceId")->references("id")->on("resource")->restrictOnDelete()->restrictOnUpdate();

            $table->primary(["resourceId", "securityCompanyId"]);

            $table->float("quantity", total: 15)->comment("in kg");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('securitycompanysafe');
    }
};
