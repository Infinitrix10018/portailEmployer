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
use Illuminate\Support\Facades\Hash;

class FournisseurController extends Controller
{

    //partie pour afficher des choses
    public function index()
    {
        $fournisseurs = Fournisseur::with('demande')->get();
        return view('ListeFournisseur', compact('fournisseurs'));
    }

    public function show()
    {
        return view('views.ListeFournisseur'); 
    }

    public function setSession($id) 
    {
        Session::put('id_fourni', $id);
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
                $fournisseur->demande->commentaire = Crypt::decryptString($fournisseur->demande->commentaire);
            } catch (\Exception $e) {
                Log::error("Failed to decrypt comment for fournisseur ID: $id_fournisseur", ['error' => $e->getMessage()]);
                $fournisseur->demande->commentaire = 'Impossible de décrypter le document';
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

    public function indexFournisseurs()
    {
       
        return view('views.ListeFournisseurRole');
    }

    public function showFournisseurs()
    {
        $fournisseurs = Fournisseur::join('demandesFournisseurs', 'demandesFournisseurs.id_fournisseurs', '=', 'fournisseurs.id_fournisseurs')
        ->select('fournisseurs.*', 'demandesFournisseurs.etat_demande')
        ->orderByRaw("FIELD(demandesFournisseurs.etat_demande, 'en attente', 'refuse', 'actif')")
        ->with('demande')
        ->get();

        return view('partials.fournisseursRoleListe', compact('fournisseurs'));
    }

    //download le document
    public function download($id_document)
    {
        \Log::info('Before download');

        $fichier = Documents::where('id_document', $id_document)->first();

        $filePath = $fichier->cheminDocument;
        $fileName = $fichier->nomDocument;
    
        if (!Storage::disk('public')->exists($filePath)) {
            \Log::error("File not found: $filePath");
            abort(404, 'File not found');
        }
    
        $fileSize = Storage::disk('public')->size($filePath);
        $mimeType = Storage::disk('public')->mimeType($filePath);
    
        return response()->download(storage_path("app/public/$filePath"), $fileName, [
            'Content-Length' => $fileSize,
            'Content-Type' => $mimeType,
        ]);
    }


    //les recherches
    public function search(Request $request)
    {
        $roleUser = Auth::user()->role;
        \Log::info('debut fonction search');

        $listeRbq = explode(",", $request->input('listeRbq'));
        $listeCode = explode(",", $request->input('listeCode'));
        $listeVille = explode(",", $request->input('listeVille'));
        $listeRegion = explode(",", $request->input('listeRegion'));

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

        $nbrRbqsTotal = count(array_filter($listeRbq));
        $nbrCodesTotal = count(array_filter($listeCode));

        $nbrCodes = !empty(array_filter($listeCode)) ? 
        'COUNT(DISTINCT CASE WHEN precision_categorie IN (' . implode(',', $codePrep) . ') THEN precision_categorie END)' : 0;
        $nbrRbqs = !empty(array_filter($listeRbq)) ? 
        'COUNT(DISTINCT CASE WHEN sous_categorie IN (' . implode(',', $rbqPrep) . ') THEN sous_categorie END)' : 0;

        $selectColumns[] = DB::raw("$nbrCodes as nbrCode");
        $selectColumns[] = DB::raw("$nbrRbqs as nbrRbq");
        $selectColumns[] = DB::raw("($nbrCodes + $nbrRbqs) as total");

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
            ->limit(50)
            ->groupBy('fournisseurs.id_fournisseurs', 'nom_entreprise',
            'ville','etat_demande');

            $results->orderBy('total', 'desc');
            
            if ($roleUser == 'Commis') {
                $results->where('etat_demande', '=', 'actif');
            } else{
                $results->orderByRaw("FIELD(etat_demande, 'actif', 'en attente', 'refuse')");
            }

            $results = $results->get();

            \Log::info('fin fonction search');
            return view('partials.fournisseursListe', compact('results', 'nbrRbqsTotal', 'nbrCodesTotal'));
            \Log::info('après logs fonction search');
    }

    public function rechercheVille(Request $request)
    {
        $searchTerm = $request->input('search');

        $ville = DB::table('fournisseurs')
            ->select('ville')
            ->where('ville', 'LIKE', '%' . $searchTerm . '%')
            ->distinct()
            ->orderBy('ville')
            ->limit(25)
            ->get();

        return response()->json($ville);
    }

    public function rechercheRegion(Request $request)
    {
        $searchTerm = $request->input('search');
        
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
            ->limit(25)
            ->get();

        return response()->json($region);
    }

    public function rechercheLicences(Request $request)
    {
        $searchTerm = $request->input('search');
        
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
            ->limit(25)
            ->get();

        return response()->json($licences);
    }

    public function rechercheCodes(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $ville = DB::table('code_unspsc')
            ->whereIn('id_code_unspsc', function($query) {
                $query->select('id_code_unspsc')
                    ->from('fournisseur_code_unspsc_liaison');
            })
            ->where(function ($query) use ($searchTerm) {
                $query->where('categorie', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('code_unspsc', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('classe_categorie', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('precision_categorie', 'LIKE', '%' . $searchTerm . '%');
            })
            ->orderBy('code_unspsc')
            ->limit(25)
            ->get();

        return response()->json($ville);
    }

    public function rechercheFournisseur(Request $request)
    {
        $searchTerm = $request->input('fournisseur');
        Log::info(['recherche fournisseur', $searchTerm]);
        $fournisseur = DB::table('fournisseurs')
            ->where('nom_entreprise', 'LIKE', '%' . $searchTerm . '%')
            ->orderBy('nom_entreprise')
            ->limit(25)
            ->get();

        return response()->json($fournisseur);
    }

    public function rechercheFichiers(string $id)
    {
        $directory = '';
        $files = Storage::disk('public')->files($directory);

        $files = Storage::disk('your_disk')->files($directory);
        $pattern = '/^' . $id . '-.*-' . $fileName . '\./';
        $matchingFiles = preg_grep($pattern, $files);
    }


    //Partie pour les contactes
    public function ajouterContact(Request $request)
    {
        \Log::info('debut fonction');
        try {
            $id_user = Auth::user()->id;
            
            Fournisseur_a_contacter::create([
                'id_user' => $id_user,
                'id_fournisseurs' => $request->input('value'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } 
        catch (\Exception $e) {
            Log::error('Erreur dans la fonction store du controller d\'inscription ' . $e->getMessage());
        }
        return response()->json(['success' => true]);
    }
    

    public function voirFournisseurAContacter()
    {
        $id_user = Auth::user()->id;
      
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
        try {
            $id_user = Auth::user()->id;
            Fournisseur_a_contacter::where([
                'id_user' => $id_user,
                'id_fournisseurs' => $request->input('value')
            ])->delete();

        } 
        catch (\Exception $e) {
            Log::error('Erreur dans la fonction store du controller d\'inscription ' . $e->getMessage());
        }
        return response()->json(['success' => true]);
    }


    //parite un peu plus test
    public function pageTest()
    {
        return view('views.test');
    }

    public function importXML()
    {
        set_time_limit(1200);
        try {
            $xml = simplexml_load_file(storage_path('app/files/stress-test.xml'));
            foreach ($xml->Fournisseur as $Fournisseur) {
                DB::transaction(function () use ($Fournisseur) {
                    
                    $inputString = (string)$Fournisseur->Coordonnees->Adresse->RegionAdministrative;
                    $lastFour = substr($inputString, -4);
                    $regionAdmin = substr($lastFour, 1, 2);

                    $NEQ = !empty($Fournisseur->Identification->NEQ) ? (string)$Fournisseur->Identification->NEQ : null;
                    $data = (string)$Fournisseur->Identification->NomEntreprise;
                    $FournisseurId = DB::table('fournisseurs')->insertGetId([
                        'NEQ' => $NEQ,
                        'email' => (string)$Fournisseur->Identification->Courriel,
                        'mdp' => Hash::make((string)$Fournisseur->Identification->MotDePasse),
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
