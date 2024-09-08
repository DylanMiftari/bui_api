<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakeCreditRequestRequest extends FormRequest
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
            "money" => ["required", "decimal:0,10"],
            "description" => ["required", "min:25"],
            "weeklypayment" => ["required", "min:1"]
        ];
    }

    public function messages(): array {
        return [
            "money.required" => "Vous devez entrer une somme pour la transaction",
            "money.decimal" => "Le montant de la transaction doit être un nombre à virgule",
            "description.description" => "Vous devez fournir une description à votre demande, expliquer par exemple à quoi servira cet argent",
            "description.min" => "La description doit faire au moins 25 caractères de long",
            "weeklypayment.required" => "Vous devez proposer une somme des paiments hebdomadaires",
            "weeklypayment.min" => "La somme proposée pour les paiments hebdomadaire doit être supérieur à 0"
        ];
    }
}
