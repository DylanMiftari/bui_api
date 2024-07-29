<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyLevel extends Model
{
    use HasFactory;

    protected $table = "companylevel";

    protected $primaryKey = "level";
}
