<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
