<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicencesRBQ extends Model
{
    use HasFactory;

    protected $table = 'licences_rbq';
    protected $primaryKey = 'id_licence_rbq';
    public $timestamps = false;

    public function licences_rbq()
    {
        return $this->belongsToMany(Fournisseur::class, 'fournisseur_licence_rbq_liaison', 'id_licence_rbq', 'id_fournisseurs');
    }
}
