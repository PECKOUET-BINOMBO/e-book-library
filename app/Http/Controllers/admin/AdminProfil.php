<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Auteur;
use App\Models\Editeur;
use App\Models\Emprunt;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\updateUser\updateUserRequest;
use App\Models\Livre;

class AdminProfil extends Controller
{
    public function index(int $id)
    {
        $user = User::find($id);
        $users = User::orderBy('id', 'desc')->paginate('5');
        $categories = Categorie::orderBy('id', 'desc')->paginate('5');
        $auteurs = Auteur::orderBy('id', 'desc')->paginate('5');
        $editeurs = Editeur::orderBy('id', 'desc')->paginate('5');
        $emprunts = Emprunt::orderBy('id', 'desc')->paginate('5');
        $livres = Livre::orderBy('id', 'desc')->paginate('5');

        return view('admin.profil.index', compact('user', 'users', 'categories', 'auteurs', 'editeurs', 'emprunts', 'livres'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(updateUserRequest $request, string $id)
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
            return redirect()->route('admin.profils.index', $user->id)->with('success', 'Profil modifié avec succès');
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
        $user->delete();

        $photo = $user->photo;
        if ($photo && $photo !== 'default.png') {
            unlink(public_path('profil/' . $photo));
        }

        if ($user) {
            return redirect()->route('accueil')->with('success', 'Compte admin supprimé avec succès');
        } else {
            return back()->with('error', 'Erreur lors de la suppression du compte');
        }

    }
}
