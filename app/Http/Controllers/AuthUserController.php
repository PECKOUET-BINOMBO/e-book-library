<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\loginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\registerRequest;

class AuthUserController extends Controller
{
    public function register_form()
    {
        return view('auth.register');
    }

    public function register(registerRequest $request)
    {
        $validatedData = $request->validated();

        $password = bcrypt($validatedData['password']);

        if (empty($validatedData['role'])) {
            $validatedData['role'] = 'user';
        }

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
            Auth::login($user);
            return redirect()->route('accueil')->with('success', 'Compte créé avec succès');
        } else {
            return back()->with('error', 'Erreur lors de l\'ajout du compte');
        }
    }

    public function login_form()
    {
        return view('auth.login');
    }

    public function login(loginRequest $request)
    {
        $credentials = $request->validated();

        if (auth()->attempt($credentials, $request->filled('remember'))) {
            return redirect()->route('accueil')->with('success', 'Connexion réussie');
        } else {
            return back()->with('error', 'Email ou mot de passe incorrect');
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('accueil')->with('success', 'Déconnexion réussie');
    }
}
