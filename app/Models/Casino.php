<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function company(): HasOne {
        return $this->hasOne(Company::class, "id", "companyId");
    }
}
