<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mafia extends Model
{
    use HasFactory;

    protected $table = "mafia";

    protected $fillable = [
        "level",
        "companyId",
        "created_at",
        "updated_at",
    ];
}
