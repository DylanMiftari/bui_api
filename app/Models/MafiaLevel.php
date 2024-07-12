<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MafiaLevel extends Model
{
    use HasFactory;
    protected $table = "mafialevel";
    protected $primaryKey = "level";
}
