<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class PlayerResource extends Model
{
    use HasFactory;
    use HasCompositeKey;
    protected $table = "playerresource";
    protected $primaryKey = ["player_id", "resource_id"];
    public $timestamps = false;
    protected $fillable = [
        "player_id",
        "resource_id",
        "quantity",
    ];
}
