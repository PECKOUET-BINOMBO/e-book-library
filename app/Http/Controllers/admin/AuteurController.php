<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Editeur;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\auteur\auteurRequest;

class AuteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $auteurs = Auteur::where('name', 'LIKE', "%{$search}%")
                ->orWhere('prenom', 'LIKE', "%{$search}%")
                ->orWhere('nationalite', 'LIKE', "%{$search}%")
                ->orderBy('id', 'desc')
                ->paginate(25);
        } else {
            $auteurs = Auteur::orderBy('id', 'desc')->paginate('25');
        }

        $users = User::orderBy('id', 'desc')->paginate('25');
        $livres = Livre::orderBy('id', 'desc')->paginate('25');
        $categories = Categorie::orderBy('id', 'desc')->paginate('25');

        $editeurs = Editeur::orderBy('id', 'desc')->paginate('25');
        return view('admin.auteurs.index', compact('users', 'livres', 'categories', 'auteurs', 'editeurs'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(auteurRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->extension();
            $photo->move(public_path('auteur'), $photoName);
        } else {
            $photoName = 'default.webp';
        }

        $auteur = Auteur::create([
            'name' => $validatedData['name'],
            'prenom' => $validatedData['prenom'],
            'date_naissance' => $validatedData['date'],
            'nationalite' => $validatedData['nationalite'],
            'biographie' => $validatedData['biographie'],
            'photo' => $photoName,
        ]);

        if ($auteur) {
            return redirect()->route('admin.auteurs.index')->with('success', 'Auteur ajouté avec succès');
        } else {
            return redirect()->route('admin.auteurs.index')->with('error', 'Erreur lors de l\'ajout de l\'auteur');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'prenom' => 'required',
            'date' => 'required',
            'nationalite' => 'required',
            'biographie' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg, webp|max:2048',
        ]);

        $auteur = Auteur::find($id);

        if ($request->hasFile('photo')) {
            $oldPhoto = $auteur->photo;
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->extension();
            $photo->move(public_path('auteur'), $photoName);

            if ($oldPhoto && $oldPhoto !== 'default.webp') {
                unlink(public_path('auteur/' . $oldPhoto));
            }
        } else {
            $photoName = $auteur->photo;
        }

        $update = Auteur::where('id', $id)->update([
            'name' => $validatedData['name'],
            'prenom' => $validatedData['prenom'],
            'date_naissance' => $validatedData['date'],
            'nationalite' => $validatedData['nationalite'],
            'biographie' => $validatedData['biographie'],
            'photo' => $photoName,
        ]);

        if ($update) {
            return redirect()->route('admin.auteurs.index')->with('success', 'Auteur modifié avec succès');
        } else {
            return redirect()->route('admin.auteurs.index')->with('error', 'Erreur lors de la modification de l\'auteur');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $auteur = Auteur::find($id);
        $delete = $auteur->delete();

        //delete photo de couverture
        $photo = $auteur->photo;
        if ($photo && $photo !== 'default.webp') {
            unlink(public_path('auteur/' . $photo));
        }

        if ($delete) {
            return redirect()->route('admin.auteurs.index')->with('success', 'Auteur supprimé avec succès');
        } else {
            return redirect()->route('admin.auteurs.index')->with('error', 'Erreur lors de la suppression de l\'auteur');
        }
    }
}
