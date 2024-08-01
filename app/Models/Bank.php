<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bank extends Model
{
    use HasFactory;

    protected $table = "bank";

    protected $fillable = [
        "accountMaintenanceCost",
        "transferCost",
        "maxAccountMoney",
        "maxAccountResource",
        "idCompany",
        "created_at",
        "updated_at",
        "level"
    ];

    public function banklevel(): HasOne {
        return $this->hasOne(BankLevel::class, "level", "level");
    }

    public function company(): HasOne {
        return $this->hasOne(Company::class, "id", "idCompany");
    }
}
