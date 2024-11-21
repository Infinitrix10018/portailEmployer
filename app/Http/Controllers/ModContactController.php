<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSingleFieldRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fournisseur;
use App\Models\Telephone;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ModContactController extends Controller
{
    public function index($id)
    {
        $id_fournisseur = $id;
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

        return view('views.pageModContact', compact('fournisseur'));
    }

    public function ChangeContact(UpdateSingleFieldRequest $request)
    {
        Log::info("//////////////////////// Start Change Contact ////////////////////////");

        $validatedData = $request->validated();

        $Info = $validatedData['Info'];
        $TypeInfo = $validatedData['TypeInfo'];
        $id_fournisseurs = $request->query('id');
        $contactId = $request->input('contact_id');

        Log::info('Change Info request received', [
            'TypeInfo' => $TypeInfo,
            'Info' => $Info,
            'id' => $id_fournisseurs,
            "ContactId" => $contactId,
        ]);

        if (!$id_fournisseurs) {
            Log::error('Fournisseur ID missing from request');
            return redirect()->back()->withErrors(['erreur' => 'Fournisseur ID is required.']);
        }

        try {
            $updated = DB::table('personne_ressource')
                ->where('id_fournisseurs', $id_fournisseurs)
                ->where('id_personne_ressource', $contactId)
                ->update([$TypeInfo => $Info]);

            if ($updated) {
                Log::info("Successfully updated field '$TypeInfo' for fournisseur ID: $id_fournisseurs");
                return redirect()->back()->with('success', 'Information changer');
            } else {
                Log::warning("Update failed for fournisseur ID: $id_fournisseurs, no matching record or no changes.");
                return redirect()->back()->withErrors(['erreur' => 'Erreur assurez-vous de valider que vos informations suivent toutes les contraintes!']);
            }
        } catch (\Exception $e) {
            Log::error('Database update error', ['exception' => $e->getMessage()]);
            return redirect()->back()->withErrors(['erreur' => 'Erreur en lien avec MYSQL']);
        }
    }
}
