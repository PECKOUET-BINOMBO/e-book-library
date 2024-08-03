<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class forgotPassRequest extends FormRequest
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
            'email' => ['required', 'email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Veuillez entrer votre adresse email',
            'email.email' => 'Veuillez entrer une adresse email valide',
            'email.exists' => 'Cette adresse email n\'existe pas',
        ];
    }
}
