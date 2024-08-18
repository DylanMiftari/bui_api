<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccountTransaction extends Model
{
    use HasFactory;
    protected $table = "bankaccounttransaction";

    protected $fillable = [
        "money",
        "description",
        "bankAccountId",
        "transfert_cost"
    ];
}
