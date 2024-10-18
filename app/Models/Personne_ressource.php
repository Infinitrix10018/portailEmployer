<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personne_ressource extends Model
{
    use HasFactory;

    protected $fillable = ['prenom_contact', 'nom_contact', 'fonction', 'email_contact', 'id_telephone', 'id_fournisseurs'];

    protected $table = 'personne_ressource';


    public function telephones()
    {
        return $this->hasMany(Telephone::class, 'id_telephone', 'id_telephone');
    }


    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'id_fournisseurs', 'id_fournisseurs');
    }
}
