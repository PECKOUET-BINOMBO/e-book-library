<?php

namespace App\Http\Requests\admin\livre;

use Illuminate\Foundation\Http\FormRequest;

class livreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titre' => 'required',
            'description' => 'required',
            'categorie' => 'required',
            'auteur' => 'required',
            'editeur' => 'required',
            'couverture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg, webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire',
            'description.required' => 'La description est obligatoire',
            'categorie.required' => 'La catégorie est obligatoire',
            'auteur.required' => 'L\'auteur est obligatoire',
            'editeur.required' => 'L\'editeur est obligatoire',
            'couverture.image' => 'Le fichier doit être une image',
            'couverture.mimes' => 'Le fichier doit être de type: jpeg, png, jpg, gif, svg, webp',
            'couverture.max' => 'Le fichier ne doit pas dépasser 2 Mo',
        ];
    }
}
