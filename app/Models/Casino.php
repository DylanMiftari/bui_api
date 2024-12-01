<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Casino extends Model
{
    use HasFactory;

    protected $table = "casino";

    protected $fillable = [
        "ticketPrice",
        "VIPTicketPrice",
        "level",
        "companyId",
        "created_at",
        "updated_at"
    ];

    public function casinolevel(): HasOne {
        return $this->hasOne(CasinoLevel::class, "level", "level");
    }

    public function tickets(): HasMany {
        return $this->hasMany(CasinoTicket::class, "casinoId", "id");
    }

    public function ticketsCount(): int {
        $now = Carbon::now();
        $expirationLimit = $now->subDays(config("casino.casino_ticket_expired_after_days"));
        return $this->tickets()->where("isVIP", false)->where("created_at", ">=", $expirationLimit)->count();
    }

    public function VIPTicketsCount(): int {
        $now = Carbon::now();
        $expirationLimit = $now->subDays(config("casino.casino_ticket_expired_after_days"));
        return $this->tickets()->where("isVIP", false)->where("created_at", ">=", $expirationLimit)->count();
    }

    public function company(): HasOne {
        return $this->hasOne(Company::class, "id", "companyId");
    }
}
