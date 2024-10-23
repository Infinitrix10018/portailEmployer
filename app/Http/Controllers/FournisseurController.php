<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fournisseur;
use App\Models\Telephone;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
        $fournisseurs = Fournisseur::with([
            'region',
            'licences_rbq',
            'code_unspsc', 
            'demande'
        ])->get();
        Log::info('Fournisseur: ', $fournisseurs->toArray());

        if (!$fournisseurs) {
            abort(404);
        }
        Log::info('Loaded Fournisseur:', $fournisseurs->toArray());

        return view('views.ListeFournisseur', compact('fournisseurs')); 
    }

    public function setSession($id) {
        Session::put('id_fourni', $id);
        //session(['id_fourni' => $id]);
        //Log::info('id fournisseur: ', $id);
        return redirect()->route('VoirFicheFournisseur');
    }

    public function showFiche()
    {
        $id_fournisseurs = Session::get('id_fourni');
        $fournisseur = Fournisseur::with([
            'region',
            'telephones',
            'personne_ressources.telephones',
            'licences_rbq',
            'code_unspsc', 
            'demande'
        ])->where('id_fournisseurs', $id_fournisseurs)
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

    //exemple chatgpt
    public function search(Request $request)
    {
        // Filter by cities
        if ($request->has('cities') && is_array($request->input('cities'))) {
            $query->whereIn('city', $request->input('cities'));
        }

        // Filter by jobs
        if ($request->has('jobs') && is_array($request->input('jobs'))) {
            $query->whereIn('job', $request->input('jobs'));
        }
        // Collect phones without an associated contact
        //$phonesWithoutContact = Telephone::whereNotIn('id_telephone', $fournisseur->personne_ressources->pluck('id_telephone'))->get();
    }

    // exemple de chat gpt
    public function rechercherDeChatGPT(Request $request)
    {
        $query = Fournisseur::query();

        // Get search parameters from request
        $villes = $request->input('city');
        $regions = $request->input('region');
        $liences_rbqs = $request->input('work_type');
        $code_unspscs = $request->input('unspsc_code');

        // Filter by city, region, and postal code
        if ($city) {
            $query->where('city', 'LIKE', "%$city%");
        }
        if ($region) {
            $query->where('region', 'LIKE', "%$region%");
        }
        if ($postalCode) {
            $query->where('postal_code', 'LIKE', "%$postalCode%");
        }

        // Filter by work type (if provided)
        if ($workType) {
            $query->whereHas('workTypes', function($q) use ($workType) {
                $q->where('name', 'LIKE', "%$workType%");
            });
        }

        // Filter by UNSPSC code (if provided)
        if ($unspscCode) {
            $query->whereHas('unspscCodes', function($q) use ($unspscCode) {
                $q->where('code', 'LIKE', "%$unspscCode%");
            });
        }

        // Execute the query and get the results
        $companies = $query->get();

        return view('companies.index', compact('companies'));
    }

    // debut de recherche pour la page voir fourniseurs
    public function rechercheDebut(Request $request)
    {
        $query = Company::query();

        // Get search parameters from request
        $city = $request->input('city');
        $region = $request->input('region');
        $postalCode = $request->input('postal_code');
        $workType = $request->input('work_type');
        $unspscCode = $request->input('unspsc_code');

        // Filter by city, region, and postal code
        if ($city) {
            $query->where('city', 'LIKE', "%$city%");
        }
        if ($region) {
            $query->where('region', 'LIKE', "%$region%");
        }
        if ($postalCode) {
            $query->where('postal_code', 'LIKE', "%$postalCode%");
        }

        // Filter by work type (if provided)
        if ($workType) {
            $query->whereHas('workTypes', function($q) use ($workType) {
                $q->where('name', 'LIKE', "%$workType%");
            });
        }

        // Filter by UNSPSC code (if provided)
        if ($unspscCode) {
            $query->whereHas('unspscCodes', function($q) use ($unspscCode) {
                $q->where('code', 'LIKE', "%$unspscCode%");
            });
        }

        // Execute the query and get the results
        $companies = $query->get();

        return view('companies.index', compact('companies'));
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
