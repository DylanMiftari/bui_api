<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DebitOrCreditBankAccountRequest extends FormRequest
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
            "money" => ["required", "decimal:0,10"]
        ];
    }

    public function messages(): array {
        return [
            "money.required" => "Vous devez entrer une somme pour la transaction",
            "money.decimal" => "Le montant de la transaction doit être un nombre à virgule"
        ];
    }
}
