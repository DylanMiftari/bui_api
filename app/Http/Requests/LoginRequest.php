<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "pseudo" => ["required", "string", "exists:player,pseudo"],
            "password" => ["required", "string"]
        ];
    }

    /**
     * Get the validation error message
     */
    public function messages()
    {
        return [
            "pseudo.required" => "Vous devez entrer un pseudo",
            "pseudo.exists" => "Ce pseudo n'existe pas",
            "password.required" => "Vos devez entrer votre mot de passe"
        ];
    }
}
