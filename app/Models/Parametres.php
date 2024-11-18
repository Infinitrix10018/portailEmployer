<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametres extends Model
{
    use HasFactory;

    protected $table = 'parametre_site';

    public $timestamps = true;

    protected $fillable = ['nom_parametre', 'valeur_parametre'];

}