<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Fournisseur_a_contacter extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'id_fournisseurs'];
    protected $table = 'fournisseur_a_contacter';
}
