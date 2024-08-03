<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Editeur;
use App\Models\Categorie;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\livre\livreRequest;
use Illuminate\Http\Request;

class AdminLivreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $livres = Livre::where('titre', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('categorie', 'LIKE', "%{$search}%")
                ->orWhere('auteur', 'LIKE', "%{$search}%")
                ->orWhere('editeur', 'LIKE', "%{$search}%")
                ->orderBy('id', 'desc')
                ->paginate(25);
        } else {
            $livres = Livre::orderBy('id', 'desc')->paginate('25');
        }

        $users = User::orderBy('id', 'desc')->paginate('25');

        $categories = Categorie::orderBy('id', 'desc')->paginate('25');
        $auteurs = Auteur::orderBy('id', 'desc')->paginate('25');
        $editeurs = Editeur::orderBy('id', 'desc')->paginate('25');
        return view('admin.livres.index', compact('users', 'livres', 'categories', 'auteurs', 'editeurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(livreRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('couverture')) {
            $couverture = $request->file('couverture');
            $couvertureName = time() . '.' . $couverture->extension();
            $couverture->move(public_path('couverture'), $couvertureName);
        } else {
            $couvertureName = 'default.webp';
        }

        $livre = Livre::create([
            'titre' => $validatedData['titre'],
            'description' => $validatedData['description'],
            'categorie' => $validatedData['categorie'],
            'auteur' => $validatedData['auteur'],
            'editeur' => $validatedData['editeur'],
            'couverture' => $couvertureName,
        ]);

        if ($livre) {
            return redirect()->route('admin.livres.index')->with('success', 'Livre ajouté avec succès');
        } else {
            return back()->with('error', 'Désolé, une erreur s\'est produite lors de l\'ajout du livre');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(livreRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $livre = Livre::find($id);

        if ($request->hasFile('couverture')) {
            $oldCouverture = $livre->couverture;
            $couverture = $request->file('couverture');
            $couvertureName = time() . '.' . $couverture->extension();
            $couverture->move(public_path('couverture'), $couvertureName);

            if ($oldCouverture && $oldCouverture !== 'default.webp') {
                unlink(public_path('couverture/' . $oldCouverture));
            }
        } else {
            $couvertureName = $livre->couverture;
        }

        $update = Livre::where('id', $id)->update([
            'titre' => $validatedData['titre'],
            'description' => $validatedData['description'],
            'categorie' => $validatedData['categorie'],
            'auteur' => $validatedData['auteur'],
            'editeur' => $validatedData['editeur'],
            'couverture' => $couvertureName,
        ]);

        if ($update) {
            return redirect()->route('admin.livres.index')->with('success', 'Livre modifié avec succès');
        } else {
            return back()->with('error', 'Désolé, une erreur s\'est produite lors de la modification du livre');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $livre = Livre::find($id);
        $delete = $livre->delete();

        //delete photo de couverture

        $couverture = $livre->couverture;
        if ($couverture && $couverture !== 'default.webp') {
            unlink(public_path('couverture/' . $couverture));
        }

        if ($delete) {
            return redirect()->route('admin.livres.index')->with('success', 'Livre supprimé avec succès');
        } else {
            return back()->with('error', 'Désolé, une erreur s\'est produite lors de la suppression du livre');
        }
    }
}
