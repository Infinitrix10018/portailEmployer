<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'email' => ['nullable', 'required_without:NEQ'], 
            'NEQ' => ['nullable', 'required_without:email'], 
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'email.required_without' => 'Un email ou un NEQ est requis.', 
            'NEQ.required_without' => 'Un NEQ ou un email est requis.', 
            'password.required' => 'Le mot de passe est requis.',
        ];
    }
}
