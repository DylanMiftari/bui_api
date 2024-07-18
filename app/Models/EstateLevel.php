<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateLevel extends Model
{
    use HasFactory;
    protected $table = "estateagencylevel";
    protected $primaryKey = "level";
}
