<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditBankRequest extends FormRequest
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
            "accountMaintenanceCost" => ["required_if:company_type,bank", "integer", "min:0"],
            "transferCost" => ["required_if:company_type,bank", "decimal:0,10", "min:0"],
            "maxAccountMoney" => ["required_if:company_type,bank", "integer", "min:0"],
            "maxAccountResource" => ["required_if:company_type,bank", "decimal:0,10", "min:0"],
        ];
    }

    public function messages(): array {
        return [
            "accountMaintenanceCost.required_if" => "Vous devez entrez des frais de tenue de compte hebdomandaire",
            "accountMaintenanceCost.integer" => "Les frais de tenue de compte doivent être un nombre",
            "accountMaintenanceCost.min" => "Les frais de tenue de compte doivent être supérieur à 0",
            "transferCost.required_if" => "Vous devez renseigner un taux de transfert",
            "transferCost.decimal" => "Le taux de transfert doit être un nombre à virgule",
            "transferCost.min" => "Le taux de transfert doit être plus grand que 0",
            "maxAccountMoney.required_if" => "Vous devez entrer une capacité maximal en argent des comptes",
            "maxAccountMoney.integer" => "La capacité en argent d'un compte en banque doit être un nombre",
            "maxAccountMoney.min" => "La capacité en argent d'un compte doit être supérieur à 0",
            "maxAccountResource.required_if" => "Vous devez entrer une capacité des comptes en ressources",
            "maxAccountResource.decimal" => "La capacité des comptes en ressources doit être un nombre",
            "maxAccountResource.min" => "La capacité des comptes en ressource doit être supérieur à 0",
        ];
    }
}
