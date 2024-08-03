<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Editeur;
use App\Models\Categorie;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\register\registerRequest;
use App\Http\Requests\admin\updateUser\updateUserRequest;
use App\Http\Requests\loginRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $users = User::where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('role', 'LIKE', "%{$search}%")
                ->orderBy('id', 'desc')
                ->paginate(25);
        } else {
            $users = User::orderBy('id', 'desc')->paginate(25);
        }

        $livres = Livre::orderBy('id', 'desc')->paginate(25);
        $categories = Categorie::orderBy('id', 'desc')->paginate(25);
        $auteurs = Auteur::orderBy('id', 'desc')->paginate(25);
        $editeurs = Editeur::orderBy('id', 'desc')->paginate(25);

        return view('admin.users.index', compact('users', 'livres', 'categories', 'auteurs', 'editeurs'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(registerRequest $request)
    {
        $validatedData = $request->validated();

        $password = bcrypt($validatedData['password']);


        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->extension();
            $photo->move(public_path('profil'), $photoName);
        } else {
            $photoName = 'default.png';
        }

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $password,
            'role' => $validatedData['role'],
            'photo' => $photoName,
        ]);

        if ($user) {
            return redirect()->route('admin.users.index')->with('success', 'Utilisateur ajouté avec succès');
        } else {
            return redirect()->route('admin.users.index')->with('error', 'Erreur lors de l\'ajout de l\'utilisateur');
        }
    }

    public function login(loginRequest $request)
    {
        $validatedData = $request->validated();

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard.index')->with('success', 'Connexion réussie');
        }


        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth()->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('admin.dashboard.index')->with('success', 'Déconnexion réussie');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(updateUserRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $user = User::find($id);

        if ($request->hasFile('photo')) {
            $oldPhoto = $user->photo;
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->extension();
            $photo->move(public_path('profil'), $photoName);

            if ($oldPhoto && $oldPhoto !== 'default.png') {
                unlink(public_path('profil/' . $oldPhoto));
            }
        } else {
            $photoName = $user->photo;
        }

        $update = User::where('id', $id)->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'photo' => $photoName,
        ]);

        if ($update) {
            return redirect()->route('admin.users.index')->with('success', 'Utilisateur modifié avec succès');
        } else {
            return redirect()->route('admin.users.index')->with('error', 'Erreur lors de la modification de l\'utilisateur');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = User::find($user->id);
        $user->delete();

        //delete photo de profil
        $photo = $user->photo;
        if ($photo && $photo !== 'default.png') {
            unlink(public_path('profil/' . $photo));
        }

        if ($user) {
            return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès');
        } else {
            return redirect()->route('admin.users.index')->with('error', 'Erreur lors de la suppression de l\'utilisateur');
        }
    }
}
