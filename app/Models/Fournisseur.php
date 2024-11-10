<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = ['NEQ', 'nom_entreprise', 'email', 'mdp', 'no_rue', 'rue', 'no_bureau', 'ville',
     'province', 'no_region_admin', 'code_postal', 'site_internet', 'commentaire'];

    protected $table = 'fournisseurs';

    public function code_unspsc()
    {
        return $this->belongsToMany(CodesUNSPSC::class, 'fournisseur_code_unspsc_liaison', 'id_fournisseurs', 'id_code_unspsc');
    }

    public function licences_rbq()
    {
        return $this->belongsToMany(LicencesRBQ::class, 'fournisseur_licence_rbq_liaison', 'id_fournisseurs', 'id_licence_rbq');
    }

    public function region()
    {
        return $this->belongsTo(Region_administrative::class, 'no_region_admin', 'no_region');
    }

    public function telephones()
    {
        return $this->hasMany(Telephone::class, 'id_fournisseurs', 'id_fournisseurs');
    }

    public function personne_ressources()
    {
        return $this->hasMany(Personne_ressource::class, 'id_fournisseurs', 'id_fournisseurs');
    }

    public function demande()
    {
        return $this->hasOne(Demande::class, 'id_fournisseurs', 'id_fournisseurs');
    }

    public function documents()
    {
        return $this->hasMany(Documents::class, 'id_fournisseurs', 'id_fournisseurs');
    }
}
