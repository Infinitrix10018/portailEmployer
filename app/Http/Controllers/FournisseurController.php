<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fournisseur;
use App\Models\Telephone;
use App\Models\Documents;
use App\Models\Fournisseur_a_contacter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

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


        $listeRbq = array_filter($listeRbq);
        $listeCode = array_filter($listeCode);

        $rbqPrep = array_map(function ($value) {
            return is_string($value) ? "'" . addslashes($value) . "'" : $value;
        }, $listeRbq);
        $codePrep = array_map(function ($value) {
            return is_string($value) ? "'" . addslashes($value) . "'" : $value;
        }, $listeCode);

        $selectColumns = [
            'fournisseurs.id_fournisseurs',
            'nom_entreprise',
            'ville',
            'etat_demande'
        ];


        // Conditionally add columns to the select based on a condition
        if (!empty(array_filter($listeRbq))) {
            $selectColumns[] = DB::raw('COUNT(DISTINCT CASE WHEN sous_categorie IN (' . implode(',', $rbqPrep) . ') THEN sous_categorie END) as nbrRbq');
            $orderByColumn = $request->input('nbrRbq');
            $nbrRbqs = count($listeRbq);
        } else {
            $nbrRbqs = 0;
        }

        if (!empty(array_filter($listeCode))) {
            $selectColumns[] = DB::raw('COUNT(DISTINCT CASE WHEN precision_categorie IN (' . implode(',', $codePrep) . ') THEN precision_categorie END) as nbrCode');
            $orderByColumn = $request->input('nbrCode');
            $nbrCodes = count($listeCode);
        }
        else {
            $nbrCodes = 0;
        }
      
        // Get the fournisseurs and their counts for both lists
        $results = DB::table('fournisseurs')
            ->leftJoin('fournisseur_licence_rbq_liaison', 'fournisseurs.id_fournisseurs', '=', 'fournisseur_licence_rbq_liaison.id_fournisseurs')
            ->leftJoin('licences_rbq', 'fournisseur_licence_rbq_liaison.id_licence_rbq', '=', 'licences_rbq.id_licence_rbq')
            ->leftJoin('fournisseur_code_unspsc_liaison', 'fournisseurs.id_fournisseurs', '=', 'fournisseur_code_unspsc_liaison.id_fournisseurs')
            ->leftJoin('code_unspsc', 'fournisseur_code_unspsc_liaison.id_code_unspsc', '=', 'code_unspsc.id_code_unspsc')
            ->leftJoin('regions_administratives', 'fournisseurs.no_region_admin', '=', 'regions_administratives.no_region')
            ->leftJoin('demandesfournisseurs', 'fournisseurs.id_fournisseurs', '=', 'demandesfournisseurs.id_fournisseurs')
            ->when(!empty(array_filter($listeRbq)), function ($query) use ($listeRbq) {
                return $query->whereIn('licences_rbq.sous_categorie', $listeRbq);
            })
            ->when(!empty(array_filter($listeCode)), function ($query) use ($listeCode) {
                return $query->whereIn('code_unspsc.precision_categorie', $listeCode); 
            })
            ->when(!empty(array_filter($listeVille)), function ($query) use ($listeVille) {
                return $query->whereIn('fournisseurs.ville', $listeVille); 
            })
            ->when(!empty(array_filter($listeRegion)), function ($query) use ($listeRegion) {
                return $query->whereIn('nom_region', $listeRegion);
            })
            ->select($selectColumns)
            ->groupBy('fournisseurs.id_fournisseurs', 'nom_entreprise',
            'ville','etat_demande');

            if (!empty($orderByColumn)) {
                if (in_array($orderByColumn)) {
                    $results->orderByDesc($orderByColumn);
                }
            }
            $results = $results->get();

            return view('partials.fournisseursListe', compact('results', 'nbrRbqs', 'nbrCodes'));
    }

    public function rechercheVille(Request $request)
    {
        // Get the search term from the query string
        $searchTerm = $request->input('search');
        
        // Perform the query to find matching cities
        $ville = DB::table('fournisseurs')
            ->select('ville')
            ->where('ville', 'LIKE', '%' . $searchTerm . '%')
            ->distinct()
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
            ->whereIn('no_region', function($query) {
                $query->select('no_region_admin')
                    ->from('fournisseurs');
            })
            ->where(function ($query) use ($searchTerm) {
                $query->where('nom_region', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('no_region', 'LIKE', '%' . $searchTerm . '%');
            })
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
            ->where(function ($query) use ($searchTerm) {
                $query->where('sous_categorie', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('categorie', 'LIKE', '%' . $searchTerm . '%');
            })
            ->orderBy('id_licence_rbq')
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
            ->orWhere('classe_categorie', 'LIKE', '%' . $searchTerm . '%')
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

    public function pageTest()
    {
        return view('views.test');
    }

    public function ajouterContact(Request $request)
    {
        \Log::info('debut fonction');
        try {
            $id_user = Auth::user()->id;
            
            \Log::info('avant enregistrement fichier dans bd');
            Fournisseur_a_contacter::create([
                'id_user' => $id_user,
                'id_fournisseurs' => $request->input('value'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        catch (\Exception $e) {
            Log::error('Erreur dans la fonction store du controller d\'inscription ' . $e->getMessage());
            //return redirect()->route('Inscription')->with('Erreur dans de formulaire');
        }
        \Log::info('fin fonction');
        return response()->json(['success' => true]);
    }

    public function voirFournisseurAContacter()
    {
        \Log::info('début fonction');
        $id_user = Auth::user()->id;
        \Log::info(['id user = ', $id_user]);
      
        // Get the fournisseurs and their counts for both lists
        $results = DB::table('fournisseurs')
            ->leftJoin('fournisseur_licence_rbq_liaison', 'fournisseurs.id_fournisseurs', '=', 'fournisseur_licence_rbq_liaison.id_fournisseurs')
            ->leftJoin('licences_rbq', 'fournisseur_licence_rbq_liaison.id_licence_rbq', '=', 'licences_rbq.id_licence_rbq')
            ->leftJoin('fournisseur_code_unspsc_liaison', 'fournisseurs.id_fournisseurs', '=', 'fournisseur_code_unspsc_liaison.id_fournisseurs')
            ->leftJoin('code_unspsc', 'fournisseur_code_unspsc_liaison.id_code_unspsc', '=', 'code_unspsc.id_code_unspsc')
            ->leftJoin('regions_administratives', 'fournisseurs.no_region_admin', '=', 'regions_administratives.no_region')
            ->leftJoin('demandesfournisseurs', 'fournisseurs.id_fournisseurs', '=', 'demandesfournisseurs.id_fournisseurs')
            ->leftJoin('fournisseur_a_contacter', 'fournisseurs.id_fournisseurs', '=', 'fournisseur_a_contacter.id_fournisseurs')
            ->where('fournisseur_a_contacter.id_user', '=', $id_user)
            ->select(
                'fournisseurs.id_fournisseurs',
                'nom_entreprise',
                'ville',
                'etat_demande')
            ->groupBy('fournisseurs.id_fournisseurs', 'nom_entreprise',
            'ville','etat_demande')
            ->get();

            return view('views.ListeFournisseurAContacter', compact('results'));
    }

    public function supprimerFournisseurAContacter(Request $request)
    {
        \Log::info('debut fonction');
        try {
            $id_user = Auth::user()->id;
            \Log::info('avant enregistrement fichier dans bd');
            Fournisseur_a_contacter::where([
                'id_user' => $id_user,
                'id_fournisseurs' => $request->input('value')
            ])->delete();

        } 
        catch (\Exception $e) {
            Log::error('Erreur dans la fonction store du controller d\'inscription ' . $e->getMessage());
            //return redirect()->route('Inscription')->with('Erreur dans de formulaire');
        }
        \Log::info('fin fonction');
        //return redirect()->route('VoirAContacter');
        return response()->json(['success' => true]);
    }

    public function importXML()
    {
        set_time_limit(300);
        try {
            $xml = simplexml_load_file(storage_path('app/files/stress-test.xml'));

            // import the data
            foreach ($xml->Fournisseur as $Fournisseur) {
                DB::transaction(function () use ($Fournisseur) {

                    $inputString = (string)$Fournisseur->Coordonnees->Adresse->RegionAdministrative;
                    // Get the last 4 characters
                    $lastFour = substr($inputString, -4);
                    // Get the middle 2 characters of the last 4
                    $regionAdmin = substr($lastFour, 1, 2);

                    $data = (string)$Fournisseur->Identification->NomEntreprise;
                    // Insert Fournisseur
                    $FournisseurId = DB::table('fournisseurs')->insertGetId([
                        'NEQ' => (string)$Fournisseur->Identification->NEQ ?: null,
                        'email' => (string)$Fournisseur->Identification->Courriel,
                        'mdp' => (string)$Fournisseur->Identification->MotDePasse,
                        'nom_entreprise' => substr($data, 0, 64),
                        'no_rue' => (string)$Fournisseur->Coordonnees->Adresse->noCivique,
                        'rue' => (string)$Fournisseur->Coordonnees->Adresse->Rue,
                        'no_bureau' => (string)$Fournisseur->Coordonnees->Adresse->Bureau,
                        'ville' => (string)$Fournisseur->Coordonnees->Adresse->Ville,
                        'province' => (string)$Fournisseur->Coordonnees->Adresse->Province,
                        'no_region_admin' => $regionAdmin,
                        'code_postal' => (string)$Fournisseur->Coordonnees->Adresse->CodePostal,
                        'site_internet' => (string)$Fournisseur->Coordonnees->SiteInternet,
                        'commentaire' => (string)$Fournisseur->ProduitsEtServices->Details,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            
                    // Insert Fournisseur details
                    DB::table('users')->insert([
                        'id_fournisseurs' => $FournisseurId,
                        'name' => (string)$Fournisseur->Identification->NomEntreprise,
                        'NEQ' => (string)$Fournisseur->Identification->NEQ,
                        'email' => (string)$Fournisseur->Identification->Courriel,
                        'password' => (string)$Fournisseur->Identification->MotDePasse,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    foreach ($Fournisseur->Coordonnees->Telephones->Telephone as $tel) {
                        DB::table('telephone')->insert([
                            'id_fournisseurs' => $FournisseurId,
                            'no_tel' => (string)$tel->Numero,
                            'type_tel' => (string)$tel->Type,
                            'poste_tel' => (string)$tel->Poste,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    foreach ($Fournisseur->Contacts->Contact as $contact) {
                        $id_tel = DB::table('telephone')->insertGetId([
                            'id_fournisseurs' => $FournisseurId,
                            'no_tel' => (string)$contact->Telephone->Numero,
                            'type_tel' => (string)$contact->Telephone->Type,
                            'poste_tel' => (string)$contact->Telephone->Poste,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        DB::table('personne_ressource')->insert([
                            'id_fournisseurs' => $FournisseurId,
                            'id_telephone' => $id_tel,
                            'prenom_contact' => (string)$contact->Prenom,
                            'nom_contact' => (string)$contact->Nom,
                            'fonction' => (string)$contact->Fonction,
                            'email_contact' => (string)$contact->Courriel,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    foreach ($Fournisseur->ProduitsEtServices->Offres->CodeUNSPSC as $code) {

                        $id_code = DB::table('code_unspsc')
                        ->where('code_unspsc', 'LIKE', '%' . $code . '%') //'sous_categorie', 'LIKE', '%' . $searchTerm . '%'
                        ->pluck('id_code_unspsc')
                        ->first();
                        
                        if (!empty($id_code)) {
                            DB::table('fournisseur_code_unspsc_liaison')->insert([
                                'id_fournisseurs' => $FournisseurId,
                                'id_code_unspsc' => $id_code,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        } else {
                           \Log::info($id_code);
                        }
                        
                    }

                    $etat = ["en attente", "actif", "refuse"];
                    $randomNumber = rand(0, 2);
                    DB::table('demandesfournisseurs')->insert([
                        'id_fournisseurs' => $FournisseurId,
                        'etat_demande' => $etat[$randomNumber],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                });
            }

            return response()->json(['success' => true, 'message' => 'XML imported successfully']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}
