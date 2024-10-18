<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fourniseur_licences_rbq_liaison extends Model
{
    use HasFactory;

    protected $fillable = ['id_fournisseurs', 'id_licence_rbq'];

    protected $table = 'fournisseur_licence_rbq_liaison';

    public function licencesRBQHas(): BelongsTo
    {
        return $this->belongsTo(LicencesRBQ::class);
    }

    public function fournisseurHas(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

}
