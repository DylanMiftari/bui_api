<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasinoLevel extends Model
{
    use HasFactory;

    protected $table = "casinolevel";
    protected $primaryKey = "level";
}
