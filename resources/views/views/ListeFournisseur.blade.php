@extends('layouts.app')
@section('title', "V3R voir les fournisseurs")
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pageFiches.css') }}">
@show
@section('js')
    <script src="{{ asset('js/pageListeFournisseurs.js') }}"></script>
@endsection
@section('content')

    <div class="container-xxl">
        <div class="row">
            <div class="col-sm-3">
                <label for="rbq">licences rbq</label> 
                <input type="text" id="rbq" name="licences_rbq" class="form-control">
            </div>
            <div class="col-sm-3">
                <label for="code">service et code unspsc</label> 
                <input type="text" id="code" name="code_unspsc" class="form-control">
            </div>
            <div class="col-sm-2">
                <label for="ville">ville</label> 
                <input type="text" id="ville" name="ville" class="form-control">
            </div>
            <div class="col-sm-2">
                <label for="region">region administrative</label> 
                <input type="text" id="region" name="region" class="form-control">
            </div>
            <div class="col-sm-2">
                <div style="text-align:center">
                <button class="button" onclick="addToLists()">Ajouter les champs de recherche</button>
                </div>
            </div>
        </div>
    </div>

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
        <div>
            <h3>Liste de licences rbq</h3>
            <ul id="listeRbq" onclick="deleteItem(event)"></ul>

            <h3>Liste des services et codes unspsc</h3>
            <ul id="listeCode" onclick="deleteItem(event)"></ul>

            <h3>Liste des villes</h3>
            <ul id="listeVille" onclick="deleteItem(event)"></ul>

            <h3>Liste des regions</h3>
            <ul id="listeRegion" onclick="deleteItem(event)"></ul>
        </div>
        <form id="listsForm" action="{{ route('VoirFiche.search') }}" method="POST">
            <input type="hidden" name="listeRbq" id="listeRbqCacher">
            <input type="hidden" name="listeCode" id="listeCodeCacher">
            <input type="hidden" name="listeVille" id="listeVilleCacher">
            <input type="hidden" name="listeRegion" id="listeRegionCacher">
            <button type="button" onclick="submitLists()">Faire une recherche</button>
        </form>
    </div>
</div>

@endsection
