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

    public function player(): HasOne {
        return $this->hasOne(User::class, "id", "playerId");
    }

    public function bankResourceAccount(): HasMany {
        return $this->hasMany(BankResourceAccount::class, "bankAccountId", "id");
    }
}
