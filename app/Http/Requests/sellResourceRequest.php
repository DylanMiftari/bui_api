<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sellResourceRequest extends FormRequest
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
            "sell_resources" => ["required", "array", "min:1"],
            "sell_resources.*.resource_id" => ["required", "integer", "exists:resource,id"],
            "sell_resources.*.quantity" => ["required", "decimal:0,10"]
        ];
    }

    public function messages(): array {
        return [
            "sell_resources.required" => "Vous devez fournir une liste de ressource à vendre",
            "sell_resources.array" => "Les ressources que vous vendez doivent être une liste",
            "sell_resources.min" => "Vous devez vendre au moins une ressource",
            "sell_resources.*.resource_id.required" => "Vous devez fournir l'id de la ressource, pour chaque ressource",
            "sell_resources.*.resource_id.integer" => "L'id des ressources doit être un nombre entier",
            "sell_resources.*.resource_id.exists" => "Un id de ressource fourni n'existe pas",
            "sell_resources.*.quantity.required" => "Pour chaque ressources vous devez préciser une quantité à vendre",
            "sell_resources.*.quantity.decimal" => "La quantité de ressource vendue doit être un nombre à virgule"
        ];
    }
}
