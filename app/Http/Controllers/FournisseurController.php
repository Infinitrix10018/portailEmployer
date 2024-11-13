<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fournisseur;
use App\Models\Telephone;
use App\Models\Documents;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class FournisseurController extends Controller
{

    public function index()
    {
        $fournisseurs = Fournisseur::with('demande')->get();
        return view('ListeFournisseur', compact('fournisseurs'));
    }

    public function show()
    {
        
        $fournisseurs = Fournisseur::with([
            'region',
            'demande'
        ])
        ->where('id_fournisseurs', -1)//mettre en commentaire si nous ne voulons pas avoir le where ici
        ->get();
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
        $id_fournisseur = Session::get('id_fourni');
        $fournisseur = Fournisseur::with([
            'region',
            'telephones',
            'personne_ressources.telephones',
            'demande'
        ])->where('id_fournisseurs', $id_fournisseur)
        ->first();

        if (!$fournisseur) {
            abort(404); 
        }

        
        if (!empty($fournisseur->demande->commentaire)) {
            try {
                Log::info("Attempt decrypt comment for fournisseur ID: $id_fournisseur");
                $fournisseur->demande->commentaire = Crypt::decryptString($fournisseur->demande->commentaire);
                Log::info("Success decrypted comment for fournisseur ID: $id_fournisseur");
            } catch (\Exception $e) {
                Log::error("Failed to decrypt comment for fournisseur ID: $id_fournisseur", ['error' => $e->getMessage()]);
                $fournisseur->demande->commentaire = 'Unable to decrypt comment';
            }
        }

        $phonesWithoutContact = Telephone::whereNotIn('id_telephone', $fournisseur->personne_ressources->pluck('id_telephone'))
            ->where('id_fournisseurs', $id_fournisseur)
            ->get();

        $licences = DB::table('licences_rbq')
            ->join('fournisseur_licence_rbq_liaison', 'licences_rbq.id_licence_rbq', '=', 'fournisseur_licence_rbq_liaison.id_licence_rbq')
            ->where('fournisseur_licence_rbq_liaison.id_fournisseurs', $id_fournisseur)
            ->get();

        $codes = DB::table('code_unspsc')
            ->join('fournisseur_code_unspsc_liaison', 'code_unspsc.id_code_unspsc', '=', 'fournisseur_code_unspsc_liaison.id_code_unspsc')
            ->where('fournisseur_code_unspsc_liaison.id_fournisseurs', $id_fournisseur)
            ->get();

        $categorieCode = $codes->groupBy('categorie');

        foreach ($categorieCode as $categorie => $items) {
            $categorieCode[$categorie] = $items->groupBy('classe_categorie');
        }

        $fichiers = Documents::where('id_fournisseurs', $id_fournisseur)->get();

        return view('views.pageVoirFiche', compact('fournisseur', 'phonesWithoutContact', 'licences', 'categorieCode', 'fichiers'));
    }

    public function download($id_document)
    {
        \Log::info('Before download');

        //$fichier = Documents::findOrFail($id_document);
        $fichier = Documents::where('id_document', $id_document)->first();

        $filePath = $fichier->cheminDocument;
        $fileName = $fichier->nomDocument;
    
        // Check if the file exists before proceeding
        if (!Storage::disk('public')->exists($filePath)) {
            \Log::error("File not found: $filePath");
            abort(404, 'File not found');
        }
    
        // Get the file size and MIME type
        $fileSize = Storage::disk('public')->size($filePath);
        $mimeType = Storage::disk('public')->mimeType($filePath);
    
        // Return the download response with custom headers
        return response()->download(storage_path("app/public/$filePath"), $fileName, [
            'Content-Length' => $fileSize,
            'Content-Type' => $mimeType,
        ]);
    }

    public function searchsomething(Request $request)
    {
        // Retrieve the form inputs
        $listeRbq = $request->input('listeRbq', []);
        $listeCode = $request->input('listeCode', []);
        $listeVille = $request->input('listeVille', []);
        $listeRegion = $request->input('listeRegion', []);
        $otherQuery1Conditions = $request->input('otherQuery1Conditions', []);
        $otherQuery2Conditions = $request->input('otherQuery2Conditions', []);

        // Start building the main SQL query
        $sql = "SELECT * FROM fournisseurs WHERE 1=1";
        $bindings = [];

        // Add the city filters using OR conditions
        if (!empty($listeVille)) {
            $sql .= " AND (";
            foreach ($listeVille as $index => $ville) {
                if ($index > 0) {
                    $sql .= " OR ";
                }
                $sql .= "city LIKE ?";
                $bindings[] = "%$ville%";
            }
            $sql .= ")";
        }

        // Add the region filters using OR conditions
        if (!empty($listeRegion)) {
            $sql .= " AND (";
            foreach ($listeRegion as $index => $region) {
                if ($index > 0) {
                    $sql .= " OR ";
                }
                $sql .= "region LIKE ?";
                $bindings[] = "%$region%";
            }
            $sql .= ")";
        }

        // Add the AND conditions for otherQuery1
        if (!empty($listeRbq)) {
            foreach ($listeRbq as $key => $rbq) {
                $sql .= " AND licences_rbq.$key = ?";
                $bindings[] = $rbq;
            }
        }

        // Add the AND conditions for otherQuery2
        if (!empty($listeCode)) {
            foreach ($listeCode as $key => $code) {
                $sql .= " AND code_unspsc.$key = ?";
                $bindings[] = $code;
            }
        }

        // Execute the raw SQL query
        $results = DB::select($sql, $bindings);

        return view('search-results', ['results' => $results]);
    }

    public function search(Request $request)
    {
        \Log::info('avant recherche');
        // Retrieve the form inputs
        $listeRbq = explode(",", $request->input('listeRbq'));
        $listeCode = explode(",", $request->input('listeCode'));
        $listeVille = explode(",", $request->input('listeVille'));
        $listeRegion = explode(",", $request->input('listeRegion'));
        \Log::info('log listes', [
            'listeRbq' => $listeRbq,
            'listeCode' => $listeCode,
            'listeVille' => $listeVille,
            'listeRegion' => $listeRegion
        ]);

         if ($listeRbq && $listeCode) {
            // Get the fournisseurs and their counts for both lists
            $results = DB::table('fournisseurs')
                ->join('fournisseur_licence_rbq_liaison', 'licences_rbq.id_licence_rbq', '=', 'fournisseur_licence_rbq_liaison.id_licence_rbq')
                ->join('fournisseurs', 'fournisseurs.id_fournisseurs', '=', 'fournisseur_licence_rbq_liaison.id_fournisseurs')
                ->join('fournisseur_code_unspsc_liaison', 'code_unspsc.id_code_unspsc', '=', 'fournisseur_code_unspsc_liaison.id_code_unspsc')
                ->join('fournisseurs', 'fournisseurs.id_fournisseurs', '=', 'fournisseur_code_unspsc_liaison.id_fournisseurs')
                ->whereIn('ville', $listeVille)
                ->whereIn('licences_rbq.categorie', $listeRbq)
                ->whereIn('code_unspsc.categorie', $listeCode)
                ->whereIn('fournisseurs.ville', $listeCode)
                ->whereIn('fournisseurs.no_region_admin', $listeCode)
                ->select('fournisseur_licence_rbq_liaison.id_fournisseurs', 
                         DB::raw('COUNT(DISTINCT CASE WHEN fournisseurs.id_fournisseurs IN (?) THEN 1 END) as listeIdRbq', [$listeRbq]),
                         DB::raw('COUNT(DISTINCT CASE WHEN fournisseurs.id_fournisseurs IN (?) THEN 1 END) as ListeIdCode', [$listeCode]))
                ->groupBy('fournisseur_licence_rbq_liaison.id_fournisseurs')
                ->orderByDesc(DB::raw('listeIdRbq + ListeIdCode'))  // Order by the sum of both counts
                ->get();
        }

         \Log::info('results:', $results->toArray());

         return view('partials.searchResults', compact('results'));
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

    public function rechercheVille(Request $request)
    {
        // Get the search term from the query string
        $searchTerm = $request->input('search');
        
        // Perform the query to find matching cities
        $ville = DB::table('fournisseurs')
            ->where('ville', 'LIKE', '%' . $searchTerm . '%')
            ->orderBy('ville')
            ->limit(10) // Optional: limit results for performance
            ->get();

        Log::info('Loaded fournisseur from ville:', $ville->toArray());
        // Return the result as JSON
        return response()->json($ville);
    }

    public function rechercheRegion(Request $request)
    {
        // Get the search term from the query string
        $searchTerm = $request->input('search');
        
        // Perform the query to find matching cities
        $region = DB::table('regions_administratives')
            ->where('nom_region', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('no_region', 'LIKE', '%' . $searchTerm . '%')
            ->orderBy('nom_region')
            ->limit(10) // Optional: limit results for performance
            ->get();

        // Return the result as JSON
        return response()->json($region);
    }

    public function rechercheLicences(Request $request)
    {
        // Get the search term from the query string
        $searchTerm = $request->input('search');
        
        // Perform the query to find matching cities
        $licences = DB::table('licences_rbq')
            ->whereIn('id_licence_rbq', function($query) {
                $query->select('id_licence_rbq')
                    ->from('fournisseur_licence_rbq_liaison');
            })
            ->where('sous_categorie', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('categorie', 'LIKE', '%' . $searchTerm . '%')
            ->orderBy('sous_categorie')
            ->limit(10) // Optional: limit results for performance
            ->get();

        // Return the result as JSON
        return response()->json($licences);
    }

    public function rechercheCodes(Request $request)
    {
        // Get the search term from the query string
        $searchTerm = $request->input('search');
        
        // Perform the query to find matching cities
        $ville = DB::table('code_unspsc')
            ->whereIn('id_code_unspsc', function($query) {
                $query->select('id_code_unspsc')
                    ->from('fournisseur_code_unspsc_liaison');
            })
            ->where('categorie', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('code_unspsc', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('sous_categorie', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('precision_categorie', 'LIKE', '%' . $searchTerm . '%')
            ->orderBy('code_unspsc')
            ->limit(10) // Optional: limit results for performance
            ->get();

        // Return the result as JSON
        return response()->json($ville);
    }

    public function rechercheFichiers(string $id)
    {
        $directory = '';
        $files = Storage::disk('public')->files($directory);

        $files = Storage::disk('your_disk')->files($directory);
        $pattern = '/^' . $id . '-.*-' . $fileName . '\./';
        $matchingFiles = preg_grep($pattern, $files);
    }

    
}
