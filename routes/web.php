<?php

use App\Models\User;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\UserConnect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\livreController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AuteurController;
use App\Http\Controllers\admin\EditeurController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AdminLivreController;
use App\Http\Controllers\admin\HistoriqueController;
use App\Http\Controllers\admin\AdminCategorieController;
use App\Livewire\Livre;




//GUEST ROUTES
Route::get('/', [livreController::class, 'index'])->name('accueil');

Route::get('/register', [AuthUserController::class, 'register_form'])->name('auth.register.form');
Route::get('/login', [AuthUserController::class, 'login_form'])->name('auth.login.form');
Route::post('/register', [AuthUserController::class, 'register'])->name('register');
Route::post('/login', [AuthUserController::class, 'login'])->name('login');

//FORGOT PASSWORD ROUTES
Route::get('/forgot-password', [AuthController::class, 'resetFormSendLink'])->name('resetFormSendLink');
Route::post('/forgot-password', [AuthController::class, 'resetSendLink'])->name('resetSendLink');
Route::get('/reset-password/{token}', [AuthController::class, 'reset_form'])->name('reset_form');
Route::post('/reset-password/{token}', [AuthController::class, 'reset'])->name('reset');


//USERS SIMPLE CONNECTED ROUTES
Route::middleware([UserConnect::class])->group(function () {

    Route::post('/livres/emprunt/{id}', [livreController::class, 'emprunt'])->name('livres.emprunt');
    Route::post('/livres/retour/{id}', [livreController::class, 'retour'])->name('livres.retour');
    Route::get('/user/profil/{id}', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/user/profil/{id}', [ProfilController::class, 'update'])->name('profil.update');
    Route::delete('/user/profil/{id}', [ProfilController::class, 'destroy'])->name('profil.destroy');
    Route::get('/logout', [AuthUserController::class, 'logout'])->name('auth.logout');
});


//ADMIN ROUTES
Route::prefix('admin')->group(function () {

    Route::get('/users/register', [AuthController::class, 'register_form'])->name('admin.auth.register.form');
    Route::get('/users/login', [AuthController::class, 'login_form'])->name('admin.auth.login.form');

    Route::middleware([AuthAdmin::class])->group(function () {
        //Dashboard routes
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');

        //User routes
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
        Route::post('/users/login', [UserController::class, 'login'])->name('admin.users.login');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        //Authentification routes

        Route::post('/users/register', [AuthController::class, 'register'])->name('admin.auth.register');
        Route::post('/users/login', [AuthController::class, 'login'])->name('admin.auth.login');
        Route::get('/users/logout', [AuthController::class, 'logout'])->name('admin.auth.logout');

        //Livre routes
        Route::get('/livres', [AdminLivreController::class, 'index'])->name('admin.livres.index');
        Route::post('/livres/store', [AdminLivreController::class, 'store'])->name('admin.livres.store');
        Route::put('/livres/{id}', [AdminLivreController::class, 'update'])->name('admin.livres.update');
        Route::delete('/livres/{livre}', [AdminLivreController::class, 'destroy'])->name('admin.livres.destroy');

        //Auteur routes
        Route::get('/auteurs', [AuteurController::class, 'index'])->name('admin.auteurs.index');
        Route::post('/auteurs/store', [AuteurController::class, 'store'])->name('admin.auteurs.store');
        Route::put('/auteurs/{id}', [AuteurController::class, 'update'])->name('admin.auteurs.update');
        Route::delete('/auteurs/{auteur}', [AuteurController::class, 'destroy'])->name('admin.auteurs.destroy');

        //Categorie routes
        Route::get('/categories', [AdminCategorieController::class, 'index'])->name('admin.categories.index');
        Route::post('/categories/store', [AdminCategorieController::class, 'store'])->name('admin.categories.store');
        Route::put('/categories/{id}', [AdminCategorieController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{livre}', [AdminCategorieController::class, 'destroy'])->name('admin.categories.destroy');

        //Editeur routes
        Route::get('/editeurs', [EditeurController::class, 'index'])->name('admin.editeurs.index');
        Route::post('/editeurs/store', [EditeurController::class, 'store'])->name('admin.editeurs.store');
        Route::put('/editeurs/{id}', [EditeurController::class, 'update'])->name('admin.editeurs.update');
        Route::delete('/editeurs/{livre}', [EditeurController::class, 'destroy'])->name('admin.editeurs.destroy');

        //Historique routes
        Route::get('/historiques', [HistoriqueController::class, 'index'])->name('admin.historiques.index');
    });
});
