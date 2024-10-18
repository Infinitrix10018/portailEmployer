<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $table = 'financesfournisseurs';
    public $timestamps = false;

    protected $fillable = ['id_fournisseur', 'no_TPS', 'no_TVQ', 'condition_paiement', 'devise', 'mode_communication'];
}
