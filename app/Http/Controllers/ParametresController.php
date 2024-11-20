<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Parametres;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ParametresController extends Controller
{
    public function index()
    {
        $courriel = Parametres::where('id_parametre_site', 1)->first();
        $delai = Parametres::where('id_parametre_site', 2)->first();
        $tailleFichier = Parametres::where('id_parametre_site', 3)->first();
        $courrielFinance = Parametres::where('id_parametre_site', 4)->first(); 

        return view('views.pageParametres', compact('courriel', 'delai', 'tailleFichier', 'courrielFinance'));
    }

    public function updateParametre(Request $request)
    {
        $validated = $request->validate([
            'courriel' => 'required|string|max:255',
            'valeur' => 'required|integer|max:64',
            'tailleFichier' => 'required|integer|max:64',
            'courrielFinance' => 'required|string|max:255',
        ]);

        Parametres::where('id_parametre_site', 1)->update(['valeur_parametre' => $request->courriel]);
        Parametres::where('id_parametre_site', 2)->update(['valeur_parametre' => $request->valeur]);
        Parametres::where('id_parametre_site', 3)->update(['valeur_parametre' => $request->tailleFichier]);
        Parametres::where('id_parametre_site', 4)->update(['valeur_parametre' => $request->courrielFinance]);
        
        return redirect()->route('VoirFiche')->with('success', 'Modèle mis à jour avec succès!');
    }


}
