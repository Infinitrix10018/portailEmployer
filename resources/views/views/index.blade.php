@extends('layouts.app')
    @section('title',"V3R Fournisseur Login")
    @section('css')
        <link rel="stylesheet" href="">
    @show
    @section('js')
        <script src=""></script>
    @endsection
    @section('content')

    <!-- Add content here!
         https://tablericons.com/ for icons
    -->

    

    <img src="{{ asset('img/V3R_Logo.svg') }}" width="50" height="50" alt="Logo V3R">
    <img src="{{ asset('img/sun.svg') }}" alt="Soleil">
    <img src="{{ asset('img/moon.svg') }}" alt="Lune">
    <img src="{{ asset('img/user.svg') }}" alt="Utilisateur">

    <form method="post" action="" enctype="multipart/form-data">
    @csrf
        <div class="main-container">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email" required>

            <label for="password">Mot de passe:</label>
            <input type="password" class="form-control" id="password" name="password" required>

            </br>

            <button type="submit" class="button">Se connecter</button>
            
            </br>

            <a href="">Nouveau Fournisseur ?</a>
        </div>
        
    </form>

    <p style="background-color:rgb(120,198,224);">couleur principale</p>
    <p style="background-color:rgb(0,118,213);">couleur principale</p>
    <p style="background-color:rgb(11,35,65); color:white;">couleur principale</p>
    <p style="background-color:rgb(197,216,0);">couleur principale</p>
    <p style="background-color:rgb(99,188,85);">couleur principale</p>
    <p style="background-color:rgb(30,73,45);">couleur principale</p>

    <p style="background-color:rgb(243,231,0);">couleur accent</p>
    <p style="background-color:rgb(249,159,215);">couleur accent</p>
    <p style="background-color:rgb(229,0,77);">couleur accent</p>
    <p style="background-color:rgb(237,140,0);">couleur accent</p>


@endsection