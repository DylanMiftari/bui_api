<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MineLevel extends Model
{
    use HasFactory;
    protected $table = "minelevel";
    protected $primaryKey = "level";
}
