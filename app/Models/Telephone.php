<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telephone extends Model
{
    use HasFactory;

    protected $fillable = ['type_tel', 'no_tel', 'poste_tel', 'id_fournisseurs'];

    protected $table = 'telephone';

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'id_fournisseurs', 'id_fournisseurs');
    }

    public function personne_ressources()
    {
        return $this->hasMany(Personne_ressource::class, 'id_telephone', 'id_telephone');
    }

    public function telephoneSansContacte($query)
    {
        return $query->whereNull('');
    }
}
