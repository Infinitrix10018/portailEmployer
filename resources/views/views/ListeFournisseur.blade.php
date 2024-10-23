@extends('layouts.app')
    @section('title',"V3R voir les fournisseurs")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageFiches.css') }}">
    @show
    @section('js')
    <script src="{{ asset('js/pageInscription.js') }}"></script>
    @endsection
    @section('content')

    <div class="row"> 
        <div class="container-xxl col-sm-8">
            @foreach ($fournisseurs as $fournisseur)
                <a href="{{ route('SetSessionFicheFournisseur', ['id' => $fournisseur->id_fournisseurs])}}">
                    <div class="row"> 
                        <p class="col-sm-3">Nom de la ville: {{ $fournisseur->nom_entreprise }} </p>
                        <p class="col-sm-3">Ville: {{ $fournisseur->ville }} </p>
                    </div>
                </a> 
            @endforeach
        </div>
        <div class="container-xxl col-sm-3">
        </div>
    </div>

@endsection