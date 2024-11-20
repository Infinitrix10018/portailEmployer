<?php

namespace App\Http\Controllers;

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

    public function ChangeContact(Request $request)
    {

    }
}
