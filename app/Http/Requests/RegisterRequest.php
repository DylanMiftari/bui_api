<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "pseudo" => ["required", "string", "min:3", "unique:player,pseudo"],
            "password" => ["required", "string", "min:3", "confirmed"],
            "password_confirmation" => ["required", "string"]
        ];
    }

    /**
     * Get the validation error message
     */
    public function messages()
    {
        return [
            'pseudo.required' => 'Un pseudo est requis',
            'pseudo.min' => 'Votre pseudo doit contenir au moins 3 caractères.',
            'pseudo.unique' => 'Ce pseudo est déjà utilisé',
            'password.required' => 'Un mot de passe est requis',
            'password.min' => 'Votre mot de passe doit faire au moins 3 caractères',
            'password.confirmed' => 'Votre mot de passe et la confirmation ne correspondent pas',
            'password_confirmation.required' => 'Vos devez confirmer votre mot de passe'
        ];
    }
}
