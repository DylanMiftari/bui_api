<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "player";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pseudo',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'companies',
        'mines'
    ];

    public function companies(): HasMany {
        return $this->hasMany(Company::class, "id_player", "id");
    }

    public function mines(): HasMany {
        return $this->hasMany(Mine::class, "player_id", "id");
    }

    public function resources(): HasManyThrough
    {
        return $this->hasManyThrough(
            Resource::class,
            PlayerResource::class,
            'player_id', // Foreign key on PlayerResource table
            'id', // Foreign key on Resource table
            'id', // Local key on Player table
            'resource_id' // Local key on PlayerResource table
        );
    }

    public function resourceWithQuantity() {
        return DB::table("playerresource")
                ->join("resource", "playerresource.resource_id", "=", "resource.id")
                ->where("player_id", $this->id)
                ->select(["id", "name", "quantity"])
                ->get();
    }
}
