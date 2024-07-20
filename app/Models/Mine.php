<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Mine extends Model
{
    use HasFactory;

    protected $table = "mine";
    protected $fillable = [
        "player_id",
        "startedAt",
        "currentTargetResourceId"
    ];
    protected $appends = [
        "remainTimeInMinute",
        "resource",
    ];

    public function resource(): HasOne {
        return $this->hasOne(Resource::class, "id", "currentTargetResourceId");
    }

    public function getRemainTimeInMinuteAttribute() {
        if($this->startedAt === null) {
            return null;
        }
        return Carbon::now()->diffInMinutes(Carbon::createFromFormat("Y-m-d H:i:s", $this->startedAt), false);
    }

    public function getResourceAttribute() {
        return $this->resource()->first();
    }
}
