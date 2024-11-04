@extends('layouts.app')
@section('title', "V3R voir les fournisseurs")
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pageFiches.css') }}">
@show
@section('js')
    <script src="{{ asset('js/pageInscription.js') }}"></script>
@endsection
@section('content')

<div class="row"> 
    <div class="container-xxl col-sm-8">

        <div class="row">
            <div class="col-sm-3"><h3>Nom de l'entreprise</h3></div>
            <div class="col-sm-3"><h3>Ville</h3></div>
            <div class="col-sm-3"><h3>Status</h3></div>
        </div>


        @foreach ($fournisseurs as $fournisseur)
            <a href="{{ route('SetSessionFicheFournisseur', ['id' => $fournisseur->id_fournisseurs]) }}" class="text-decoration-none">
                <div class="row"> 
                    <div class="col-sm-3"><p>{{ $fournisseur->nom_entreprise }}</p></div>
                    <div class="col-sm-3"><p>{{ $fournisseur->ville }}</p></div>
                    <div class="col-sm-3"><p>{{ $fournisseur->demande->etat_demande ?? 'No Status' }}</p></div>
                </div>
            </a> 
        @endforeach
    </div>
    <div class="container-xxl col-sm-3">
</div>

@endsection
