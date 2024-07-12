<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoryMachine extends Model
{
    use HasFactory;

    protected $table = "factorymachine";

    protected $fillable = [
        "factoryId",
        "currentRecipeId",
        "created_at",
        "updated_at"
    ];
}
