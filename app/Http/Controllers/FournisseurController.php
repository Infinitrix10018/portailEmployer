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
            'demande'
        ])->where('id_fournisseurs', $id_fournisseurs)
        ->first();

        $phonesWithoutContact = Telephone::whereNotIn('id_telephone', $fournisseur->personne_ressources->pluck('id_telephone'))->get();

        $licences = DB::table('licences_rbq')
        ->join('fournisseur_licence_rbq_liaison', 'licences_rbq.id_licence_rbq', '=', 'fournisseur_licence_rbq_liaison.id_licence_rbq')
        ->where('fournisseur_licence_rbq_liaison.id_fournisseurs', $id_fournisseurs)
        ->get();

        $codes = DB::table('code_unspsc')
        ->join('fournisseur_code_unspsc_liaison', 'code_unspsc.id_code_unspsc', '=', 'fournisseur_code_unspsc_liaison.id_code_unspsc')
        ->where('fournisseur_code_unspsc_liaison.id_fournisseurs', $id_fournisseurs)
        ->get();

        if (!$fournisseur) {
            abort(404); // Handle the case when the supplier is not found
        }

        Log::info('Loaded Fournisseur:', $fournisseur->toArray());
        Log::info('Phones:', $fournisseur->telephones->toArray());
        Log::info('Contacts:', $fournisseur->personne_ressources->toArray());
        Log::info('Loaded Fournisseur:', $licences->toArray());
        Log::info('Loaded Fournisseur:', $codes->toArray());

        return view('views.pageVoirFiche', compact('fournisseur', 'phonesWithoutContact', 'licences', 'codes'));
        
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

    public function rechercheFichiers(string $id)
    {
        $directory = '';
        $files = Storage::disk('public')->files($directory);

        $files = Storage::disk('your_disk')->files($directory);
        $pattern = '/^' . $id . '-.*-' . $fileName . '\./';
        $matchingFiles = preg_grep($pattern, $files);
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
