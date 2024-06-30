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
        Schema::create('securitycompanyprotectionrequest', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("playerId");
            $table->foreign("playerId")->references("id")->on("player")->cascadeOnDelete()->restrictOnUpdate();

            $table->string("protectionType", 50);

            $table->float("price", total: 20);
            $table->float("secondPrice", total: 20)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('securitycompanyprotectionrequest');
    }
};
