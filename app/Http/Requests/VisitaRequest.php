<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitaRequest extends FormRequest
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
            'ticket_id' => 'required|exists:tickets,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'comenzada' => 'required|boolean',
            'terminada' => 'required|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ticket_id' => 'El ticket debe existir para registar la visita',
            'latitude.required' => 'El campo latitude es obligatorio.',
            'longitude.required' => 'El campo longitude es obligatorio.',
            'comenzada.required' => 'El campo comenzada es obligatorio.',
        ];
    }
}