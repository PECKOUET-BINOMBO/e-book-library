<?php

namespace App\Http\Controllers\admin;

use App\Mail\Reset;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Doctrine\Common\Lexer\Token;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\loginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\forgotPassRequest;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\admin\register\registerRequest;
use App\Mail\Register;

class AuthController extends Controller
{
    public function register_form()
    {
        return view('admin.auth.register');
    }

    public function register(registerRequest $request)
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
        $passwordNoCrypt = $validatedData['password'];

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $password,
            'role' => $validatedData['role'],
            'photo' => $photoName,
        ]);

        if ($user) {
            //Mail::to([$validatedData['email']])->send(new Register($user, $passwordNoCrypt));
            Mail::to([$validatedData['email']])->queue(new Register($user, $passwordNoCrypt));
            Auth::login($user);
            return redirect()->route('admin.auth.login')->with('success', 'Utilisateur ajouté avec succès');
        } else {
            return back()->with('error', 'Erreur lors de l\'ajout de l\'utilisateur');
        }
    }

    public function login_form()
    {
        return view('admin.auth.login');
    }

    public function login(loginRequest $request)
    {
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            return redirect()->route('admin.dashboard.index')->with('success', 'Connexion réussie');
        } else {
            return back()->with('error', 'Email ou mot de passe incorrect');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.auth.login')->with('success', 'Déconnexion réussie');
    }

    public function resetFormSendLink()
    {
        return view('admin.auth.resetFormSendLink');
    }

    public function resetSendLink(ForgotPassRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('email', $request->email)->first();

        if ($user) {

            $token = Str::random(60);

            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]);

            //Mail::to([$request->email])->send(new Reset($user, $token));
            Mail::to([$request->email])->queue(new Reset($user, $token));

            return back()->with('success', 'Email envoyé avec succès');
        } else {
            return back()->with('error', 'Email non trouvé');
        }
    }


    public function reset_form($token)
    {

        return view('admin.auth.resetFormUpdate');
    }

    public function reset(Request $request, $token)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:4',
        ]);

        $user = User::where('email', $request->email)->first();

        $table_reset = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('email', $request->email)
            ->first();

        if ($user && $table_reset) {
            DB::table('password_reset_tokens')->where('token', $token)->delete();
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('auth.login.form')->with('success', 'Mot de passe réinitialisé avec succès');
        } else {
            return back()->with('error', 'Erreur lors de la réinitialisation du mot de passe, ce lien a expiré');
        }
    }
}
