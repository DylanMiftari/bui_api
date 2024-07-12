<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    use HasFactory;

    protected $table = "securitycompany";

    protected $fillable = [
        "companyId",
        "created_at",
        "updated_at",
        "level",
    ];
}
