<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class BankResourceAccount extends Model
{
    use HasFactory;
    use HasCompositeKey;

    protected $table = "bankresourceaccount";
    protected $primaryKey = ["bankAccountId", "resourceId"];

    protected $fillable = [
        "bankAccountId",
        "resourceId",
        "quantity",
    ];

    public $timestamps = false;

}
