<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function bankAccounts(): HasMany {
        return $this->hasMany(BankAccount::class, "bankId", "id");
    }

    public function getDataForClient(): array {
        return [
            "id" => $this->id,
            "accountMaintenanceCost" => $this->accountMaintenanceCost,
            "transferCost" => $this->transferCost,
            "maxAccountMoney" => $this->maxAccountMoney,
            "maxAccountResource" => $this->maxAccountResource,
            "idCompany" => $this->idCompany,
            "level" => $this->level,
            "company" => $this->company->getDataForClient(),
        ];
    }
}
