<?php

namespace App\Http\Requests\casino;

use Illuminate\Foundation\Http\FormRequest;

class BuyTicketRequest extends FormRequest
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
            "isVIP" => ["required", "boolean"]
        ];
    }

    public function messages(): array {
        return [
            "isVIP.required" => "Vous devez indiquer si vous acheter un ticket VIP ou non",
            "isVIP.boolean" => "Il n'y a que des tickets VIP ou normals"
        ];
    }
}
