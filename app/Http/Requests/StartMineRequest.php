<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartMineRequest extends FormRequest
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
            "resource_id" => ["required", "integer", "exists:resource,id"]
        ];
    }

    public function messages(): array {
        return [
            "resource_id.required" => "Vous devez renseigner un id de ressource",
            "resource_id.integer" => "L'id de la ressource doit être un nombre entier",
            "resource_id.exists" => "L'id de la ressource doit exister"
        ];
    }
}
