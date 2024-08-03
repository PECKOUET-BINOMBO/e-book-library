<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Editeur;
use App\Models\Categorie;
use App\Models\Historique;
use Termwind\Components\Li;
use Illuminate\Http\Request;

class livreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->categorie;

        if ($search) {
            $livres = Livre::where('titre', 'like', "%$search%")->orWhere('auteur', 'like', "%$search%")->orWhere('categorie', 'like', "%$search%")->orWhere('editeur', 'like', "%$search%")->paginate('50');
        } else {
            $livres = Livre::orderBy('id', 'desc')->paginate('50');
        }



        $users = User::all();
        $categories = Categorie::orderBy('name', 'asc')->get();
        $auteurs = Auteur::all();
        $editeurs = Editeur::all();
        $emprunts = Emprunt::all();
        return view('livres.index', compact('users', 'livres', 'categories', 'auteurs', 'editeurs', 'emprunts'));
    }

    public function emprunt(string $id){

        $user_id = auth()->user()->id;
        $livre_id = $id;

        $update_statut_livre = Livre::where('id', $livre_id)->update(['statut' => 'indisponible']);

        $emprunt = Emprunt::create([
            'user_id' => $user_id,
            'livre_id' => $livre_id,
            'date_emprunt' => now(),
            'date_retour' => now()->addDays(15)
        ]);

        $historique = Historique::create([
            'user_id' => $user_id,
            'livre_id' => $livre_id,
            'date_emprunt' => now(),
            'date_retour' => now()->addDays(15)
        ]);

        if ($update_statut_livre && $emprunt && $historique) {
            return redirect()->route('accueil')->with('success', 'Livre emprunté avec succès, vous avez 15 jours pour le retourner');
        } else {
            return back()->with('error', 'Erreur lors de l\'emprunt du livre');
        }


    }

    public function retour(string $id){

        $livre_id = $id;

        //delete emprunt
        $delete_emprunt = Emprunt::where('livre_id', $livre_id)->delete();
        $update_statut_livre = Livre::where('id', $livre_id)->update(['statut' => 'disponible']);

        if ($update_statut_livre) {
            return redirect()->route('accueil')->with('success', 'Livre retourné avec succès');
        } else {
            return back()->with('error', 'Erreur lors du retour du livre');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
