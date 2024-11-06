<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ModelCourriel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ModelCourrielController extends Controller
{
    public function listeModelCourriel()
    {
        $modelCourriel = ModelCourriel::all();

        return view('views.pageModelCourriel', compact('modelCourriel'));
    }
}
