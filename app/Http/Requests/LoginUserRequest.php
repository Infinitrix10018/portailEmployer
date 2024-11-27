<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'required'], 
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Un email est requis.', 
            'password.required' => 'Le mot de passe est requis.',
        ];
    }
}
