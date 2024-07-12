<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
