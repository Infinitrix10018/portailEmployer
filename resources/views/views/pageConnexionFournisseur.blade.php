@extends('layouts.app')
    @section('title',"V3R Fournisseur Page Connexion N")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageConnexionFournisseur.css') }}">
    @show
    @section('content')

    <div class="title"><h1>Connexion</h1></div>

    <div>
        <div class="left-rectangle"></div>
        <div class="right-rectangle"></div>

        <div class="shape1"></div>
        <div class="shape2"></div>
        <div class="shape3"></div>
    </div>
    
    <form method="post" action="{{ route('Login') }}" enctype="multipart/form-data">
    @csrf
        <div class="main-container">
            <label id="emailLabel" for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email" required>

            <label for="password">Mot de passe:</label>
            <input type="password" class="form-control" id="password" name="password" required>

            <button type="submit" class="button">Se connecter</button>
            </br>
            <a onclick="NeqOrEmail()" class="button" id="btNEQPage">Se connecter avec un NEQ</a>
        </div>
        
    </form>

    @section('js')
        <script src="{{ asset('js/connectionType.js') }}"></script>
    @endsection

@endsection