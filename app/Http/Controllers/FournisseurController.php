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

        // Get the fournisseurs and their counts for both lists
        $results = DB::table('fournisseurs')
            ->join('fournisseur_licence_rbq_liaison', 'fournisseurs.id_fournisseurs', '=', 'fournisseur_licence_rbq_liaison.id_fournisseurs')
            ->join('licences_rbq', 'fournisseur_licence_rbq_liaison.id_licence_rbq', '=', 'licences_rbq.id_licence_rbq')
            //->join('fournisseur_code_unspsc_liaison', 'fournisseurs.id_fournisseurs', '=', 'fournisseur_code_unspsc_liaison.id_fournisseurs')
            //->join('code_unspsc', 'fournisseur_code_unspsc_liaison.id_code_unspsc', '=', 'code_unspsc.id_code_unspsc')
            //->join('regions_administratives', 'fournisseurs.no_region_admin', '=', 'regions_administratives.no_region')
            ->whereIn('licences_rbq.categorie', $listeRbq)
            //->whereIn('code_unspsc.categorie', $listeCode)
            ->whereIn('fournisseurs.ville', $listeVille)
            //->whereIn('fournisseurs.no_region_admin', $listeRegion)
            /*
            ->select('fournisseur_licence_rbq_liaison.id_fournisseurs', 
                    DB::raw('COUNT(DISTINCT CASE WHEN fournisseurs.id_fournisseurs IN (' . implode(',', $listeRbq ?? []) . ') THEN 1 END) as listeIdRbq'),
                    DB::raw('COUNT(DISTINCT CASE WHEN fournisseurs.id_fournisseurs IN (' . implode(',', $listeCode ?? []) . ') THEN 1 END) as ListeIdCode'))
            */
            //->groupBy('fournisseurs.id_fournisseurs')
            //->orderByDesc(DB::raw('listeIdRbq + ListeIdCode'))  // Order by the sum of both counts
            ->get();

         \Log::info('results:', $results->toArray());

         return view('partials.fournisseursListe', compact('results'));
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
