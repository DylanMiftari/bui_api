<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $table = "city";

    protected $hidden = [];

    public function users(): HasMany {
        return $this->hasMany(User::class, "city_id", "id");
    }

    public function companies(): HasMany {
        return $this->hasMany(Company::class, "city_id", "id");
    }
}
