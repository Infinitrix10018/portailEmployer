<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodesUNSPSC extends Model
{
    use HasFactory;

    protected $table = 'code_unspsc';
    protected $primaryKey = 'id_code_unspsc';
    public $timestamps = false;

    public function code_unspsc()
    {
        return $this->belongsToMany(Fournisseur::class, 'fournisseur_code_unspsc_liaison', 'id_code_unspsc', 'id_fournisseurs');
    }
}
