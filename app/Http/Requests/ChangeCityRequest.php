<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeCityRequest extends FormRequest
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
            "city_id" => ["required", "integer", "exists:city,id"]
        ];
    }

    public function messages() : array {
        return [
            "city_id.required" => "Vous devez entrer l'id de la ville de desitnation",
            "city_id.integer" => "L'id de la ville de destination doit être un nombre entier",
            "city_id.exists" => "La ville demandée n'existe pas"
        ];
    }
}
