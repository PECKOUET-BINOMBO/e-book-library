<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Editeur;
use App\Models\Categorie;
use App\Http\Controllers\Controller;
use App\Models\Historique;
use Illuminate\Http\Request;

class HistoriqueController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;


        if ($search) {


            $historiques = Historique::where('livre_id', 'LIKE', "%{$search}%")
                ->orWhere('user_id', 'LIKE', "%{$search}%")
                ->orWhere('date_emprunt', 'LIKE', "%{$search}%")
                ->orWhere('date_retour', 'LIKE', "%{$search}%")
                ->paginate(25);
        } else {
            $historiques = Historique::orderBy('id', 'desc')->paginate(25);
        }

        $users = User::orderBy('id', 'desc')->paginate('5');
        $livres = Livre::orderBy('id', 'desc')->paginate('5');
        $categories = Categorie::orderBy('id', 'desc')->paginate('5');
        $auteurs = Auteur::orderBy('id', 'desc')->paginate('5');
        $editeurs = Editeur::orderBy('id', 'desc')->paginate('5');

        return view('admin.historiques.index', compact('historiques', 'users', 'livres', 'categories', 'auteurs', 'editeurs'));
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
