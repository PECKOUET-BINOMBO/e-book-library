<?php

namespace App\Http\Requests\admin\updateUser;

use Illuminate\Foundation\Http\FormRequest;

class updateUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être une adresse email valide',
            'role.required' => 'Le rôle est obligatoire',
            'photo.image' => 'Le fichier doit être une image',
            'photo.mimes' => 'Le fichier doit être de type: jpeg, png, jpg, gif, svg',
            'photo.max' => 'Le fichier ne doit pas dépasser 2 Mo',
        ];
    }
}
