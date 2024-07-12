<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;

    protected $table = "estateagency";

    protected $fillable = [
        "companyId",
        "level",
        "created_at",
        "updated_at"
    ];
}
