<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class House extends Model
{
    use HasFactory;

    protected $table = "house";

    protected $fillable = [
        "houseTypeId"
    ];

    public function houseType(): HasOne {
        return $this->hasOne(HouseType::class, "id", "houseTypeId");
    }
}
