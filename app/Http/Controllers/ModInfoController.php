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

class ModInfoController extends Controller
{
    
    public function index()
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

        return view('views.pageModInfo', compact('fournisseur', 'phonesWithoutContact', 'licences', 'categorieCode', 'fichiers'));
    }

    public function ChangeInfo(Request $request)
    {

    }









}
