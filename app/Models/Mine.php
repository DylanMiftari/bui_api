<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mine extends Model
{
    use HasFactory;

    protected $table = "mine";
    protected $fillable = [
        "player_id",
        "startedAt",
        "currentTargetResourceId"
    ];

    public function resource(): HasOne {
        return $this->hasOne(Resource::class, "id", "currentTargetResourceId");
    }
}
