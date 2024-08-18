<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = "bankaccount";

    protected $fillable = [
        "accountMaintenanceCost",
        "transferCost",
        "maxMoney",
        "maxResource",
        "bankId",
        "playerId"
    ];

    public function player(): HasOne {
        return $this->hasOne(User::class, "id", "playerId");
    }

    public function bankResourceAccount(): HasMany {
        return $this->hasMany(BankResourceAccount::class, "bankAccountId", "id");
    }

    public function transactions(): HasMany {
        return $this->hasMany(BankAccountTransaction::class, "bankAccountId", "id");
    }

    public function bank(): HasOne {
        return $this->hasOne(Bank::class, "id", "bankId");
    }
}
