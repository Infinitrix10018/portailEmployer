<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModStatusController extends Controller
{
    public function index()
    {
        return view('views.pageModStatus');
    }

    public function changeStatus(Request $request)
    {
        $status = $request->input('status');
        $comment = $request->input('comment');
        $id_fournisseurs = $request->query('id');

        $updated = DB::table('demandesFournisseurs')
                 ->where('id_fournisseurs', $id_fournisseurs)
                 ->update(['etat_demande' => ($status === 'actif') ? 'Actif' : 'Refusé']);

        if ($updated) 
        {
            return redirect()->back()->with('success', 'État de la demande mis à jour avec succès !');
        }

        return redirect()->back()->withErrors(['erreur' => 'Fournisseur non trouvé.']);

    }
}
