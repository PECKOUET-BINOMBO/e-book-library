<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Editeur;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $livres = Livre::all();
        $categories = Categorie::all();
        $auteurs = Auteur::all();
        $editeurs = Editeur::all();

        

        return view('admin.dashboard.index', compact('users', 'livres', 'categories', 'auteurs', 'editeurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
