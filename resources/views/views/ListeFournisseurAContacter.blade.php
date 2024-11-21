@extends('layouts.app')
@section('title', "V3R voir les fournisseurs")
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pageFiches.css') }}">
@show
@section('js')
    <script>
        const searchUrl = "{{ route('VoirFiche.search') }}";
    </script>
    <script src="{{ asset('js/pageListeFournisseurs.js') }}"></script>
@endsection
@section('content')

@if($results->isNotEmpty())

    <div class="row">
        <div class="col-sm-3"><h3>Nom de l'entreprise</h3></div>
        <div class="col-sm-3"><h3>Ville</h3></div>
        <div class="col-sm-2"><h3>Status</h3></div>
        <div class="col-sm-2"><h3>licences rbq</h3></div>
        <div class="col-sm-2"><h3>services</h3></div>
    </div>

    @foreach ($results as $result)
        <div>
            <a href="{{ route('SetSessionFicheFournisseur', ['id' => $result->id_fournisseurs]) }}" class="text-decoration-none">
                <div class="row"> 
                    <div class="col-sm-6"><p>{{ $result->nom_entreprise }}</p></div>
                    <div class="col-sm-6"><p>{{ $result->ville }}</p></div>
                </div>
            </a> 
        </div>
    @endforeach

@else   
    <h4>
        Aucun résultat
    </h4>
@endif

@endsection
