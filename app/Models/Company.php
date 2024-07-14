<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Keep order
    const COMPANY_TYPE = ["bank", "casino", "estate_agency", "factory", "mafia", "security"];
    const FRENCH_COMPANY_TYPE = ["Banque", "Casino", "Agence immobilière", "Usine", "Mafia", "Agence de sécurité"];

    protected $table = "company";

    protected $fillable = [
        "name",
        "money_in_safe",
        "id_player",
        "created_at",
        "updated_at",
        "companylevel",
        "company_type"
    ];
}
