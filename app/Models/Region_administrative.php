<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region_administrative extends Model
{
    use HasFactory;

    protected $table = 'regions_administratives';

    public function fournisseur()
    {
        return $this->hasMany(Fournisseur::class, 'no_region_admin', 'no_region');
    }
}
