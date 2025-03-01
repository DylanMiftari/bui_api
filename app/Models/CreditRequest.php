<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CreditRequest extends Model
{

    public const STATUS_LIST = ["wait on bank", "wait on client"];

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

    public function player(): HasOne {
        return $this->hasOne(User::class, "id", "playerId");
    }
}
