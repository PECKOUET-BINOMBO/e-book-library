<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Editeur;
use App\Models\Categorie;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\editeur\editeurRequest;
use Illuminate\Http\Request;

class EditeurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $editeurs = Editeur::where('name', 'LIKE', "%{$search}%")
                ->orderBy('id', 'desc')
                ->paginate(25);
        } else {
            $editeurs = Editeur::orderBy('id', 'desc')->paginate('25');
        }

        $users = User::orderBy('id', 'desc')->paginate('25');
        $livres = Livre::orderBy('id', 'desc')->paginate('25');
        $categories = Categorie::orderBy('id', 'desc')->paginate('25');
        $auteurs = Auteur::orderBy('id', 'desc')->paginate('25');

        return view('admin.editeurs.index', compact('users', 'livres', 'categories', 'auteurs', 'editeurs'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(editeurRequest $request)
    {
        $validatedData = $request->validated();

        $editeur = Editeur::create([
            'name' => $validatedData['name'],
        ]);

        if ($editeur) {
            return redirect()->route('admin.editeurs.index')->with('success', 'Editeur ajouté avec succès');
        } else {
            return redirect()->route('admin.editeurs.index')->with('error', 'Erreur lors de l\'ajout de l\'editeur');
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(editeurRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $editeur = Editeur::where('id', $id)->update([
            'name' => $validatedData['name'],
        ]);

        if ($editeur) {
            return redirect()->route('admin.editeurs.index')->with('success', 'Editeur modifié avec succès');
        } else {
            return redirect()->route('admin.editeurs.index')->with('error', 'Erreur lors de la modification de l\'editeur');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $editeur = Editeur::find($id);
        $delete = $editeur->delete();

        if ($delete) {
            return redirect()->route('admin.editeurs.index')->with('success', 'Editeur supprimé avec succès');
        } else {
            return redirect()->route('admin.editeurs.index')->with('error', 'Erreur lors de la suppression de l\'editeur');
        }
    }
}
