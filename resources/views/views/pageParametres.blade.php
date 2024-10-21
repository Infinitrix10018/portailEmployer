@extends('layouts.app')
    @section('title',"V3R Fournisseur Accueil")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageAccueil.css') }}">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')
    <h1>Parametres</h1>

    
    @section('js')
        <script src="{{ asset('js/slideShow.js') }}"></script>
    @endsection
@endsection