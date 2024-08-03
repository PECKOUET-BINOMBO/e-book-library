<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Editeur;
use App\Models\Categorie;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\categorieRequest;
use Illuminate\Http\Request;

class AdminCategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $categories = Categorie::where('name', 'LIKE', "%{$search}%")
                ->orderBy('id', 'desc')
                ->paginate(25);
        } else {
            $categories = Categorie::orderBy('id', 'desc')->paginate('25');
        }

        $users = User::orderBy('id', 'desc')->paginate('25');
        $livres = Livre::orderBy('id', 'desc')->paginate('25');

        $auteurs = Auteur::orderBy('id', 'desc')->paginate('25');
        $editeurs = Editeur::orderBy('id', 'desc')->paginate('25');
        return view('admin.categories.index', compact('users', 'livres', 'categories', 'auteurs', 'editeurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(categorieRequest $request)
    {
        $validatedData = $request->validated();

        $categorie = Categorie::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        if ($categorie) {
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie ajoutée avec succès');
        } else {
            return redirect()->route('admin.categories.index')->with('error', 'Erreur lors de l\'ajout de la catégorie');
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(categorieRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $categorie = Categorie::find($id);



        $update = $categorie->update([
            'name' => $validatedData['name'],
            'description' => $request->description,
        ]);

        if ($update) {
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie modifiée avec succès');
        } else {
            return redirect()->route('admin.categories.index')->with('error', 'Erreur lors de la modification de la catégorie');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categorie = Categorie::find($id);

        $delete = $categorie->delete();


        if ($delete) {
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès');
        } else {
            return redirect()->route('admin.categories.index')->with('error', 'Erreur lors de la suppression de la catégorie');
        }
    }
}
