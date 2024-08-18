<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

   

    public function user(): HasOne {
        return $this->hasOne(User::class, "id", "id_player");
    }

    public function bank(): HasOne {
        return $this->hasOne(Bank::class, "idCompany", "id");
    }
    public function casino(): HasOne {
        return $this->hasOne(Casino::class, "companyId", "id");
    }
    public function factory(): HasOne {
        return $this->hasOne(Factory::class, "companyId", "id");
    }
    public function estateAgency(): HasOne {
        return $this->hasOne(Estate::class, "companyId", "id");
    }
    public function mafia(): HasOne {
        return $this->hasOne(Mafia::class, "companyId", "id");
    }
    public function security(): HasOne {
        return $this->hasOne(Security::class, "companyId", "id");
    }

    public function getDataForClient(): array {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "id_player" => $this->id_player,
            "companylevel" => $this->companylevel,
            "company_type" => $this->company_type,
            "city_id" => $this->city_id,
            "activated" => $this->activated,
        ];
    }
}
