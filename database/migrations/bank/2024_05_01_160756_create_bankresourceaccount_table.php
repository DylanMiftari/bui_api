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
        Schema::create('bankresourceaccount', function (Blueprint $table) {
            $table->unsignedBigInteger("bankAccountId");
            $table->unsignedBigInteger("resourceId");
            $table->primary(["bankAccountId", "resourceId"]);

            $table->float("quantity", total: 15)->comment("in kg");

            $table->foreign("bankAccountId")->references("id")->on("bankaccount")->restrictOnDelete()->restrictOnUpdate();
            $table->foreign("resourceId")->references("id")->on("resource")->restrictOnDelete()->restrictOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bankresourceaccount');
    }
};
