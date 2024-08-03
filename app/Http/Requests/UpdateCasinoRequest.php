<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCasinoRequest extends FormRequest
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
            "ticketPrice" => ["decimal:0,10", "min:0"],
            "VIPTicketPrice" => ["decimal:0,10", "min:0"],
        ];
    }

    public function messages(): array {
        return [
            "ticketPrice.decimal" => "Le prix du ticket doit être un nombre à virgule",
            "ticketPrice.min" => "Le prix du ticket doit être supérieur à 0",
            "VIPTicketPrice.decimal" => "Le prix du ticket VIP doit être un nombre à virgule",
            "VIPTicketPrice.min" => "Le prix du ticket doit être supérieur à 0",
        ];
    }
}
