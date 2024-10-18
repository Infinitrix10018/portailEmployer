<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fournisseur;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fournisseurs = Fournisseur->get();

        return view('ListeFournisseur', compact('fournisseurs'));
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
    public function show()
    {
        $id_fournisseur = Auth::user()->id_fournisseurs;
        $fournisseur = Fournisseur::with([
            'region',
            'telephones',
            'personne_ressources.telephones',
            'licences_rbq',
            'code_unspsc', 
            'demande'
        ])->where('id_fournisseurs', $id_fournisseur)
        ->first();

        // Collect phones without an associated contact
        $phonesWithoutContact = Telephone::whereNotIn('id_telephone', $fournisseur->personne_ressources->pluck('id_telephone'))->get();


        // Log the main fournisseur data
        Log::info('Fournisseur: ', $fournisseur->toArray());

        // Log the count of telephones
        Log::info('Telephones count: ' . $fournisseur->telephones->count());

        // Log the count of personne ressources
        Log::info('Personne Ressources count: ' . $fournisseur->personne_ressources->count());

        foreach ($fournisseur->personne_ressources as $personne) {
            Log::info('Personne Ressource ID: ' . $personne->id_personne_ressource);
            Log::info('Personne Ressource Telephones count: ' . $personne->telephones->count());
        }

        foreach ($fournisseur->personne_ressources as $personne) {
            Log::info('Personne Resource: ', $personne->toArray());
            if ($personne->telephone) {
                Log::info('Personne Resource Telephone: ', $personne->telephone->toArray());
            }
        }

        if (!$fournisseur) {
            abort(404); // Handle the case when the supplier is not found
        }

        Log::info('Loaded Fournisseur:', $fournisseur->toArray());
        Log::info('Phones:', $fournisseur->telephones->toArray());
        Log::info('Contacts:', $fournisseur->personne_ressources->toArray());

        return view('views.pageVoirFiche', compact('fournisseur', 'phonesWithoutContact'));
        
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
