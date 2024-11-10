<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $fillable = ['id_fournisseurs', 'nomDocument', 'cheminDocument', 'extension_document', 'taille_document'];

    protected $table = 'documents';
 
    public function fournisseur()
    {
        return $this->belongTo(Fournisseur::class, 'id_fournisseurs', 'id_fournisseurs');
    }
}
