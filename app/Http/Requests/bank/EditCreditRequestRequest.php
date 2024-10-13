<?php

namespace App\Http\Requests\bank;

use Illuminate\Foundation\Http\FormRequest;

class EditCreditRequestRequest extends FormRequest
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
            "rate" => ["decimal:0,10", "min:0"],
            "money" => ["decimal:0,10", "min:1"],
            "weeklyPayments" => ["decimal:0,10", "min:1"],
            "description" => ["string"]
        ];
    }

    public function messages(): array {
        return [
            "rate.decimal" => "Le taux du prêt doit être un nombre à virgule",
            "rate.min" => "Le taux du prêt ne doit pas être inférieur à 0",

            "money.decimal" => "La quantité d'argent demandée doit être un nombre",
            "money.min" => "La quantité d'argent demandée doit être supérieur à 1",

            "weeklyPayments.decimal" => "La somme des paiements hebdomadaire doit être un nombre",
            "weeklyPayments.min" => "La somme des paiements hebdomadaire doit être supérieur à 1",

            "description" => "La description doit être un texte"
        ];
    }
}
