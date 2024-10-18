<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class PersonFormRequest extends FormRequest
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

            'prenom.personne_ressource' => 'nullable|string|max:32|regex:/^[a-zA-Z0-9]{1,32}$/',
            'nom.personne_ressource' => 'nullable|string|max:32|regex:/^[a-zA-Z0-9]{1,32}$/',
            'fonction.personne_ressource' => 'nullable|string|max:32|regex:/^[a-zA-Z0-9]{1,32}$/',
            'email_contact.personne_ressource' => 'nullable|string|max:32|regex:/^[\w\.-]+@[\w\.-]+\.\w{2,}$/',
            
            'type_tel.personne_ressource' => 'nullable|string|in:bureau,cellulaire,fax',
            'no_tel.personne_ressource' => 'nullable|string|max:15|regex:/^(\+?\d{1,3}[-.\s]?)?(\(?\d{2,3}\)?[-.\s]?)?(\d{3,4}[-.\s]?)?\d{3,4}$/',
            'poste_tel.personne_ressource' => 'nullable|string|max:10|regex:/^[0-9]+$/',
            
        ];

        return $rules;
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
            'prenom.personne_ressource.regex' => 'Le prenom doit être entre 1-32 caracteres et ne doit pas contenir de caracteres spéciaux.',
            'nom.personne_ressource.regex' => 'Le nom doit être entre 1-32 caracteres et ne doit pas contenir de caracteres spéciaux.',
            'fonction.personne_ressource.regex' => 'La fonction de la personne doit être entre 1-32 caracteres et ne doit pas contenir de caracteres spéciaux.',
            'email_contact.personne_ressource.regex' => 'L\'adresse email doit être valide de format email@email.com.',
            'no_tel.personne_ressource.regex' => 'Le numéro de téléphone ne doit être composé que de chiffres.',
            'poste_tel.personne_ressource.regex' => 'Le numéro de téléphone ne doit être composé que de chiffres.',
        ];
    }
}
