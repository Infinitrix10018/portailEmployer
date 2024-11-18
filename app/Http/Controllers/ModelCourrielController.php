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
        Log::info('model :', $model->toArray());
        return view('views.pageModifierModelCourriel', compact('model'));
}

    public function updateModele(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:model_courriel,id_model_courriel',
            'nom' => 'required|string|max:250',
            'objet' => 'required|string|max:64',
            'message' => 'required|string|max:512',
        ]);

        ModelCourriel::where(['id_model_courriel' => $request->id ])->update([
            'nom_courriel' => $request->nom,
            'objet' => $request->objet,
            'message' => $request->message,
        ]); 
        /*
        $model = ModelCourriel::findOrFail($validated['id']);
        $model->nom_courriel = $validated['nom'];
        $model->objet = $validated['objet'];
        $model->message = $validated['message'];
        $model->save();
        */
        return redirect()->route('listeModelCourriel')->with('success', 'Modèle mis à jour avec succès!');
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
