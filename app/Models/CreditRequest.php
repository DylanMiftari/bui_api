<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditRequest extends Model
{
    use HasFactory;
    protected $table = "creditrequest";

    protected $fillable = [
        "status",
        "money",
        "rate",
        "playerId",
        "bankId",
        "description",
        "weeklypayment"
    ];
}
