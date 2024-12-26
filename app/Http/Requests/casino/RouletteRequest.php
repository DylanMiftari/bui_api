<?php

namespace App\Http\Requests\casino;

use Illuminate\Foundation\Http\FormRequest;

class RouletteRequest extends FormRequest
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
            "bet" => "required|decimal:0,10|min:1"
        ];
    }

    public function messages(): array {
        return [
            "bet.required" => "Vous devez entrer une mise",
            "bet.decimal" => "Votre mise doit être un nombre à virgule",
            "bet.min" => "Votre mise doit être au minimum de 1"
        ];
    }
}
