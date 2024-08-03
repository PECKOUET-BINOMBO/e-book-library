<?php

namespace App\Http\Requests\admin\auteur;

use Illuminate\Foundation\Http\FormRequest;

class auteurRequest extends FormRequest
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
            'prenom' => 'required',
            'date' => 'required',
            'nationalite' => 'required',
            'biographie' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg, webp|max:2048',
        ];
    }

    public function messages(): array{
        return [
            'name.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'date.required' => 'La date de naissance est obligatoire',
            'nationalite.required' => 'La nationalité est obligatoire',
            'biographie.required' => 'La biographie est obligatoire',
            'photo.image' => 'Le fichier doit être une image',
            'photo.mimes' => 'Le fichier doit être de type: jpeg, png, jpg, gif, svg, webp',
            'photo.max' => 'Le fichier ne doit pas dépasser 2 Mo',
        ];
    }
}
