<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class PhoneFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'type_tel.fournisseur' => 'nullable|string|in:bureau,cellulaire,fax',
            'no_tel.fournisseur' => 'nullable|string|max:20|regex:/^(\+?\d{1,3}[-.\s]?)?(\(?\d{2,3}\)?[-.\s]?)?(\d{3,4}[-.\s]?)?\d{3,4}$/',
            'poste_tel.fournisseur' => 'nullable|string|max:10|regex:/^[0-9]+$/',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        // Log the request data
        Log::error('Validation failed', [
            'errors' => $validator->errors(),
            'request_data' => $this->all(),
        ]);

        // Throw the validation exception
        throw new ValidationException($validator);
    }

    public function messages()
    {
        return [
            'no_tel.personne_ressource.regex' => 'Le numéro de téléphone ne doit être composé que de chiffres, il peut avoir un format comme ceux-ci : 1(123)123 1234 , 12345678901, 1 (123) 123-1234.',
            'poste_tel.personne_ressource.regex' => 'Le numéro de téléphone ne doit être composé que de chiffres.',
        ];
    }
}
