<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ModelCourriel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ModelCourrielController extends Controller
{
    public function listeModelCourriel()
    {
        $modelCourriel = ModelCourriel::all();

        return view('views.pageModelCourriel', compact('modelCourriel'));
    }

    public function showModifierForm(Request $request)
{
        $selectedModele = $request->query('modele');

        $model = ModelCourriel::where('nom_courriel', $selectedModele)->first();
    
        return view('views.pageModifierModelCourriel', compact('model'));
}


    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:250',
            'objet' => 'required|string|max:64',
            'message' => 'required|string|max:512',
        ]);

        Log::info($request->all());

        ModelCourriel::create([
            'nom_courriel' => $request->input('nom'),
            'objet' => $request->input('objet'),
            'message' => $request->input('message'),
        ]);

        return redirect()->back()->with('success', 'Modèle de courriel ajouté avec succès!');
    }
}
