<?php

namespace App\Http\Controllers;

use App\Http\Requests\updateProfilRequest;
use App\Models\User;
use App\Models\Emprunt;
use App\Models\Historique;
use App\Models\Livre;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $id)
    {

        $user = User::find($id);

        $historiques = Historique::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);

        // Récupérer les titres correspondant à chaque livre
        $titres = [];
        foreach ($historiques as $historique) {
            $livre = Livre::find($historique->livre_id);
            $titres[$historique->id] = $livre->titre;
        }

        return view('profil.index', compact('user', 'historiques', 'titres'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(updateProfilRequest $request, string $id)
    {
        $validated = $request->validated();

        $user = User::find($id);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->extension();
            $photo->move(public_path('profil'), $photoName);
        } else {
            $photoName = $user->photo;
        }

        if ($request->password) {
            $password = bcrypt($validated['password']);
        } else {
            $password = $user->password;
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $password,
            'photo' => $photoName,
        ]);

        if ($user) {
            return redirect()->route('profil.index', $user->id)->with('success', 'Profil modifié avec succès');
        } else {
            return back()->with('error', 'Erreur lors de la modification du profil');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user = User::find($id);

        // Récupérer tous les emprunts de l'utilisateur
        $emprunts_user = Emprunt::where('user_id', $user->id)->get();

        // Mettre à jour le statut des livres associés
        foreach ($emprunts_user as $emprunt) {
            $livre = Livre::find($emprunt->livre_id);
            $livre->statut = 'disponible'; // Mettre à jour le statut
            $livre->save(); // Sauvegarder les changements
        }

        // Supprimer tous les emprunts de l'utilisateur
        foreach ($emprunts_user as $emprunt) {
            $emprunt->delete();
        }

        // Récupérer et supprimer tous les historiques de l'utilisateur
        $historiques_user = Historique::where('user_id', $user->id)->get();
        foreach ($historiques_user as $historique) {
            $historique->delete();
        }

        // Supprimer l'utilisateur
        $user->delete();

        return redirect()->route('accueil')->with('success', 'Compte supprimé avec succès');
    }


}
