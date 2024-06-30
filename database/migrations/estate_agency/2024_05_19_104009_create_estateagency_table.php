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
        Schema::create('estateagency', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("companyId");
            $table->foreign("companyId")->references("id")->on("company")->cascadeOnDelete()->restrictOnUpdate();
            $table->unsignedSmallInteger("level")->default("1");
            $table->foreign("level")->references("level")->on("estateagencylevel")->restrictOnDelete()->restrictOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estateagency');
    }
};
