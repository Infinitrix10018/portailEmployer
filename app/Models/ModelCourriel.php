<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCourriel extends Model
{
    use HasFactory;

    protected $table = 'model_courriel';

    protected $fillable = ['id_model_courriel', 'nom_courriel', 'objet', 'message'];

}