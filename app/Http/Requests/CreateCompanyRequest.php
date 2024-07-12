<?php

namespace App\Http\Requests;

use App\Models\BankLevel;
use App\Models\CasinoLevel;
use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "string", "min:3", "unique:company,name"],
            "company_type" => ["required", "string", "in:".implode(",", Company::COMPANY_TYPE)],

            // Bank fields
            "accountMaintenanceCost" => ["required_if:company_type,bank", "integer", "min:0"],
            "transferCost" => ["required_if:company_type,bank", "decimal:0,10", "min:0"],
            "maxAccountMoney" => ["required_if:company_type,bank", "integer", "min:0", "max:".BankLevel::find(1)->maxMoneyAccount],
            "maxAccountResource" => ["required_if:company_type,bank", "decimal:0,10", "min:0", "max:".BankLevel::find(1)->maxResourceAccount],

            // Casino fields
            "ticketPrice" => ["required_if:company_type,casino", "integer", "min:0", "max:". CasinoLevel::find(1)->maxTicketPrice],
            "rouletteSequenceMultiplicator" => ["required_if:company_type,casino", "decimal:0,10", "min:0"],
            "rouletteTripletMultiplicator" => ["required_if:company_type,casino", "decimal:0,10", "min:0"],
            "rouletteTripleSeventMultiplicator" => ["required_if:company_type,casino", "decimal:0,10", "min:0"],
            "rouletteMaxBet" => ["required_if:company_type,casino", "integer", "min:0", "max:". CasinoLevel::find(1)->rouletteMaxBet],
        ];
    }

    public function messages(): array {
        return [
            "name.required" => "Vous devez renseigner un nom d'entreprise",
            "name.min" => "Le nom de votre entreprise doit contenir au moins 3 caractères",
            "name.unique" => "Ce nom est déjà utilisé",
            "company_type.required" => "Vous devez renseigner un type d'entreprise",
            "company_type.in" => "Le type de votre entreprise doit être parmi eux : ".implode(", ", Company::COMPANY_TYPE),

            // Bank fields
            "accountMaintenanceCost.required_if" => "Vous devez entrez des frais de tenue de compte hebdomandaire",
            "accountMaintenanceCost.integer" => "Les frais de tenue de compte doivent être un nombre",
            "accountMaintenanceCost.min" => "Les frais de tenue de compte doivent être supérieur à 0",
            "transferCost.required_if" => "Vous devez renseigner un taux de transfert",
            "transferCost.decimal" => "Le taux de transfert doit être un nombre à virgule",
            "transferCost.min" => "Le taux de transfert doit être plus grand que 0",
            "maxAccountMoney.required_if" => "Vous devez entrer une capacité maximal en argent des comptes",
            "maxAccountMoney.integer" => "La capacité en argent d'un compte en banque doit être un nombre",
            "maxAccountMoney.min" => "La capacité en argent d'un compte doit être supérieur à 0",
            "maxAccountMoney.max" => "Pour une banque de niveau 1, la capacité en argent d'un compte ne peut pas dépasser : ".BankLevel::find(1)->maxMoneyAccount,
            "maxAccountResource.required_if" => "Vous devez entrer une capacité des comptes en ressources",
            "maxAccountResource.decimal" => "La capacité des comptes en ressources doit être un nombre",
            "maxAccountResource.min" => "La capacité des comptes en ressource doit être supérieur à 0",
            "maxAccountResource.max" => "La capacité des comptes en ressource pour une banque de niveau 1 ne peut pas dépasser : ".BankLevel::find(1)->maxResourceAccount."kg",

            // Casino fields
            "ticketPrice.required_if" => "Vous devez entrer un prix pour vos tickets d'entrées",
            "ticketPrice.integer" => "Le prix de vos tickets doit être un nombre",
            "ticketPrice.min" => "Vos tickets ne peuvent pas coûter moins de 0",
            "ticketPrice.max" => "Pour un casino de niveau 1, vous ne pouvez pas vendre les tickets à plus de ". CasinoLevel::find(1)->maxTicketPrice,
            "rouletteSequenceMultiplicator.required_if" => "Vous devez séléctionner un multiplicateur de gain pour vos jeux",
            "rouletteSequenceMultiplicator.decimal" => "Le multiplicateur doit être un nombre à virgule",
            "rouletteSequenceMultiplicator.min" => "Le multiplicateur ne peut pas être inférieur à 0",
            "rouletteTripletMultiplicator.required_if" => "Vous devez séléctionner un multiplicateur de gain pour vos jeux",
            "rouletteTripletMultiplicator.decimal" => "Le multiplicateur doit être un nombre à virgule",
            "rouletteTripletMultiplicator.min" => "Le multiplicateur ne peut pas être inférieur à 0",
            "rouletteTripleSeventMultiplicator.required_if" => "Vous devez séléctionner un multiplicateur de gain pour vos jeux",
            "rouletteTripleSeventMultiplicator.decimal" => "Le multiplicateur doit être un nombre à virgule",
            "rouletteTripleSeventMultiplicator.min" => "Le multiplicateur ne peut pas être inférieur à 0",
            "rouletteMaxBet.required_if" => "Vous devez entrer une mise maximal",
            "rouletteMaxBet.integer" => "La mise maximale doit être un nombre",
            "rouletteMaxBet.min" => "la mise maximale autorisée ne peut pas être inférieur à 0",
            "rouletteMaxBet.max" => "Pour un casino de niveau 1, la mise maximale autorisée doit être inférieur à ". CasinoLevel::find(1)->rouletteMaxBet,
        ];
    }
}
