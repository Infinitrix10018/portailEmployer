@extends('layouts.app')
@section('title', "page test")
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
                <form id="listsForm" action="{{ route('test.rbq') }}" method="POST">
                @csrf
                    <label for="rechercheRbq">licences rbq</label> 
                    <input type="text" id="rechercheRbq" name="licences_rbq" class="form-control">
                    <div id="rbqSuggestions" class="suggestions-container"></div>
                    <button type="button" class="button">Faire une recherche</button>
                </form>
            </div>
            <div class="col-sm-3">
                <form id="listsForm" action="{{ route('test.code') }}" method="POST">
                @csrf
                    <label for="rechercheCode">service et code unspsc</label> 
                    <input type="text" id="rechercheCode" name="code_unspsc" class="form-control">
                    <div id="codeSuggestions" class="suggestions-container"></div>
                    <button type="button" class="button">Faire une recherche</button>
                </form>
                
            </div>
            <div class="col-sm-2">
                <form id="listsForm" action="{{ route('test.ville') }}" method="POST">
                @csrf
                    <label for="rechercheVille">ville</label> 
                    <input type="text" id="rechercheVille" name="ville" class="form-control">
                    <div id="villeSuggestions" class="suggestions-container"></div>
                    <button type="button" class="button">Faire une recherche</button>
                </form>
            </div>
            <div class="col-sm-2">
            <form id="listsForm" action="{{ route('test.region') }}" method="POST">
                @csrf
                    <label for="rechercheRegion">region administrative</label> 
                    <input type="text" id="rechercheRegion" name="region" class="form-control">
                    <div id="regionSuggestions" class="suggestions-container"></div>
                    <button type="button" class="button">Faire une recherche</button>
                </form>
            </div>
        </div>
    </div>
@endsection
