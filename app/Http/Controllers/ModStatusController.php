<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Models\ModelCourriel;


class ModStatusController extends Controller
{
    public function index()
    {
        return view('views.pageModStatus');
    }

    public function changeStatus(Request $request)
    {
        // Si la checkbox est on

        if (isset($_POST['envoiCommentaire'])) {

            $id_fournisseurs = $request->query('id');
        
                $fournisseur = DB::table('fournisseurs')->where('id_fournisseurs', $id_fournisseurs)->first();
                
                if ($fournisseur && $fournisseur->email) {

                    $emailContent = ModelCourriel::first();

                    if ($emailContent) {
                        Mail::to($fournisseur->email)->send(new WelcomeMail($emailContent));
                    }
                } else {
                    Log::warning("Pas d'email trouvé pour l'utilisateur ID : $id_fournisseurs");
                }

            Log::info('Received changeStatus request', [
                'status' => $request->input('status'),
                'comment' => $request->input('comment'),
                'id' => $request->query('id')
            ]);
            $status = $request->input('status');
            $comment = $request->input('comment');
            $id_fournisseurs = $request->query('id');

            if (!$id_fournisseurs) {
                Log::error('No id_fournisseurs found in request');
                return redirect()->back()->withErrors(['erreur' => 'Fournisseur ID is missing from request.']);
            }

            if ($comment) {
                Log::info("Encrypting comment");
                $comment = Crypt::encryptString($comment);
            }

            if ($status === "comment"){
                Log::info("Attempting to update comment for fournisseur ID: $id_fournisseurs");

                $updated = DB::table('demandesFournisseurs')
                    ->where('id_fournisseurs', $id_fournisseurs)
                    ->update([
                        'commentaire' => $comment
                    ]);
            }
            else{
                Log::info("Attempting to update etat_demande and comment for fournisseur ID: $id_fournisseurs");

                $updated = DB::table('demandesFournisseurs')
                    ->where('id_fournisseurs', $id_fournisseurs)
                    ->update([
                        'etat_demande' => ($status === 'actif') ? 'Actif' : 'Refusé',
                        'commentaire' => $comment
                    ]);
            }
            
            if ($updated) {
                Log::info("Successfull update for fournisseur ID: $id_fournisseurs");
                return redirect()->back()->with('success', 'État de la demande/commentaire mis à jour avec succès !');
            } else {
                Log::warning("No matching fournisseur found for ID: $id_fournisseurs or update failed");
                return redirect()->back()->withErrors(['erreur' => 'Fournisseur non trouvé.']);
            }

        } else { 
            // Si la checkbox est off
            Log::info('Received changeStatus request', [
                'status' => $request->input('status'),
                'comment' => $request->input('comment'),
                'id' => $request->query('id')
            ]);
            $status = $request->input('status');
            $comment = $request->input('comment');
            $id_fournisseurs = $request->query('id');

            if (!$id_fournisseurs) {
                Log::error('No id_fournisseurs found in request');
                return redirect()->back()->withErrors(['erreur' => 'Fournisseur ID is missing from request.']);
            }

            if ($comment) {
                Log::info("Encrypting comment");
                $comment = Crypt::encryptString($comment);
            }

            if ($status === "comment"){
                Log::info("Attempting to update comment for fournisseur ID: $id_fournisseurs");

                $updated = DB::table('demandesFournisseurs')
                    ->where('id_fournisseurs', $id_fournisseurs)
                    ->update([
                        'commentaire' => $comment
                    ]);
            }
            else{
                Log::info("Attempting to update etat_demande and comment for fournisseur ID: $id_fournisseurs");

                $updated = DB::table('demandesFournisseurs')
                    ->where('id_fournisseurs', $id_fournisseurs)
                    ->update([
                        'etat_demande' => ($status === 'actif') ? 'Actif' : 'Refusé',
                        'commentaire' => $comment
                    ]);
            }
            
            if ($updated) {
                Log::info("Successfull update for fournisseur ID: $id_fournisseurs");
                return redirect()->back()->with('success', 'État de la demande/commentaire mis à jour avec succès !');
            } else {
                Log::warning("No matching fournisseur found for ID: $id_fournisseurs or update failed");
                return redirect()->back()->withErrors(['erreur' => 'Fournisseur non trouvé.']);
            }
        }
            
    }
}
