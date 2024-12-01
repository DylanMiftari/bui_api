<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
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
        'mines',
        "city"
    ];

    public function companies(): HasMany {
        return $this->hasMany(Company::class, "id_player", "id");
    }

    public function mines(): HasMany {
        return $this->hasMany(Mine::class, "player_id", "id");
    }

    public function city(): HasOne {
        return $this->hasOne(City::class, "id", "city_id");
    }

    public function casinoTickets(): HasMany {
        return $this->hasMany(CasinoTicket::class, "playerId", "id");
    }

    public function casinoTicket(Casino $casino): CasinoTicket|null {
        $now = Carbon::now();
        $expirationLimit = $now->subDays(config("casino.casino_ticket_expired_after_days"));
        return $this->casinoTickets()->where("casinoId", $casino->id)
        ->where("created_at", ">=", $expirationLimit)->first();
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

    public function homes(): HasMany {
        return $this->hasMany(Home::class, "id_player", "id");
    }

    public function homesInCity() {
        return $this->homes->filter(function(Home $home) {
            $home->house->load("houseType");
            return $home->house->city_id === $this->city->id;
        });
    }

    public function bankAccounts(): HasMany {
        return $this->hasMany(BankAccount::class, "playerId", "id");
    }

    public function storableMoney(): float {
        return round(config("player.max_money") - $this->playerMoney, 2);
    }

    public function storableResources(): float {
        return round(config("player.max_resource") - $this->resourceWithQuantity()->sum("quantity"), 2);
    }

    public function addResource(int $resourceId, float $quantity): void {
        $playerResource = PlayerResource::where("player_id", $this->id)->where("resource_id", $resourceId)->first();
        if($playerResource === null) {
            PlayerResource::create([
                "player_id" => $this->id,
                "resource_id" => $resourceId,
                "quantity" => $quantity
            ]);
        } else {
            $playerResource->quantity += $quantity;
            $playerResource->save();
        }
    }

    public function resourceQuantity(Resource $resource): float {
        $resources = $this->resourceWithQuantity()->keyBy("name");
        return $resources->has($resource->name) ? $resources[$resource->name]->quantity : 0;
    }

    public function removeResource(Resource $resource, float $quantity) {
        $playerResource = PlayerResource::where("player_id", $this->id)->where("resource_id", $resource->id)->first();
        $playerResource->quantity = round($playerResource->quantity - $quantity, 2);
        if($playerResource->quantity == 0) {
            $playerResource->delete();
        } else {
            $playerResource->save();
        }
    }
}
