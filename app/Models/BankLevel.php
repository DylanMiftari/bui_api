<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankLevel extends Model
{
    use HasFactory;

    protected $table = "banklevel";
    protected $primaryKey = "level";
}
