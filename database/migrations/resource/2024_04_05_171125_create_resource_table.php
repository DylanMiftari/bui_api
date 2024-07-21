<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resource', function (Blueprint $table) {
            $table->unsignedBigInteger("id")->primary();
            $table->string("name", length: 50);
            $table->float("marketPrice", total: 20)->comment("Price for 0.1kg");
            $table->integer("timeToMine", unsigned: true)->nullable()->comment("in minutes | null = not mineable");
            $table->float("mineQuantity", total: 15)->nullable()->comment("in kg | null = not mineable");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table("resource")->truncate();
        Schema::dropIfExists('resource');
    }
};
