<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Home extends Model
{
    use HasFactory;

    protected $table = "home";

    protected $fillable = [
        "id_house",
        "id_player",
        "rent",
    ];

    public function house(): HasOne {
        return $this->hasOne(House::class, "id", "id_house");
    }

}
