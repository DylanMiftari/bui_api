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
        Schema::create('securityhousealarm', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("homeId");
            $table->foreign("homeId")->references("id")->on("home")->cascadeOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });

        Schema::create('securitycompanyalarm', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("companyId");
            $table->foreign("companyId")->references("id")->on("company")->cascadeOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });

        Schema::create('securitypepperspray', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("playerId");
            $table->foreign("playerId")->references("id")->on("player")->cascadeOnDelete()->restrictOnUpdate();

            $table->boolean("used")->default(false);

            $table->timestamps();
        });

        Schema::create('securitybankgasdispenser', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("bankId");
            $table->foreign("bankId")->references("id")->on("bank")->cascadeOnDelete()->restrictOnUpdate();

            $table->boolean("isEmpty")->default(false);

            $table->timestamps();
        });

        Schema::create('securitycompanygasdispenser', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("companyId");
            $table->foreign("companyId")->references("id")->on("company")->cascadeOnDelete()->restrictOnUpdate();

            $table->boolean("isEmpty")->default(false);

            $table->timestamps();
        });

        Schema::create('securityreinforceddoor', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("homeId");
            $table->foreign("homeId")->references("id")->on("home")->cascadeOnDelete()->restrictOnUpdate();

            $table->boolean("isBroken")->default(false);

            $table->timestamps();
        });

        Schema::create('securityhomebodyguard', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("homeId");
            $table->foreign("homeId")->references("id")->on("home")->cascadeOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });

        Schema::create('securityplayerbodyguard', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("playerId");
            $table->foreign("playerId")->references("id")->on("player")->cascadeOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });

        Schema::create('securitybanksecurityguard', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("bankId");
            $table->foreign("bankId")->references("id")->on("bank")->cascadeOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });

        Schema::create('securitycompanysecurityguard', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("companyId");
            $table->foreign("companyId")->references("id")->on("company")->cascadeOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });

        Schema::create('securitycyberdefense', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("companyId");
            $table->foreign("companyId")->references("id")->on("company")->cascadeOnDelete()->restrictOnUpdate();

            $table->timestamps();
        });

        Schema::create('securityplayerantiaisystem', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("playerId");
            $table->foreign("playerId")->references("id")->on("player")->cascadeOnDelete()->restrictOnUpdate();

            $table->boolean("isBroken")->default(false);

            $table->timestamps();
        });

        Schema::create('securityhomeantiaisystem', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("homeId");
            $table->foreign("homeId")->references("id")->on("home")->cascadeOnDelete()->restrictOnUpdate();

            $table->boolean("isBroken")->default(false);

            $table->timestamps();
        });

        Schema::create('securitycompanycontainmentsystem', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("companyId");
            $table->foreign("companyId")->references("id")->on("company")->cascadeOnDelete()->restrictOnUpdate();

            $table->boolean("isBroken")->default(false);
            $table->boolean("isUnload")->default(false);

            $table->timestamps();
        });

        Schema::create('securitybankcontainmentsystem', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("securityCompanyId");
            $table->foreign("securityCompanyId")->references("id")->on("securityCompany")->cascadeOnDelete()->restrictOnUpdate();

            $table->unsignedBigInteger("bankId");
            $table->foreign("bankId")->references("id")->on("bank")->cascadeOnDelete()->restrictOnUpdate();

            $table->boolean("isBroken")->default(false);
            $table->boolean("isUnload")->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('securityhousealarm');
        Schema::dropIfExists('securitycompanyalarm');
        Schema::dropIfExists('securitypepperspray');
        Schema::dropIfExists('securitybankgasdispenser');
        Schema::dropIfExists('securitycompanygasdispenser');
        Schema::dropIfExists('securityreinforceddoor');
        Schema::dropIfExists('securityhomebodyguard');
        Schema::dropIfExists('securityplayerbodyguard');
        Schema::dropIfExists('securitybanksecurityguard');
        Schema::dropIfExists('securitycompanysecurityguard');
        Schema::dropIfExists('securitycyberdefense');
        Schema::dropIfExists('securityplayerantiaisystem');
        Schema::dropIfExists('securityhomeantiaisystem');
        Schema::dropIfExists('securitycompanycontainmentsystem');
        Schema::dropIfExists('securitybankcontainmentsystem');
    }
};
