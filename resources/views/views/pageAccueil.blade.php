@extends('layouts.app')
    @section('title',"V3R Fournisseur Accueil")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageAccueil.css') }}">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')
    <h1>Votre Portail Fournisseur</h1>
    <div>
        <button type="submit" class="button" id="buttonLeft" onclick="showPrevSlide()"><</button>
        
        <div id="slideShow">
            <img src="{{ asset('img/stockImg1.jpg') }}" alt="img1" id="slide1" class="slide" style="opacity: 1;">
            <img src="{{ asset('img/stockImg2.jpg') }}" alt="img2" id="slide2" class="slide" style="opacity: 0;">
            <img src="{{ asset('img/stockImg3.jpg') }}" alt="img3" id="slide3" class="slide" style="opacity: 0;">
        </div>

        <div id="slideShowText">
            <h3 class="text" style="opacity: 1;">Hello this is a test</h3>
            <h3 class="text" style="opacity: 0;">Hello this is working</h3>
            <h3 class="text" style="opacity: 0;">Lets a go itsa me mario</h3>
        </div>

        <button type="button" class="button" id="buttonRight" onclick="showNextSlide()">></button>
    </div>

    
    @section('js')
        <script src="{{ asset('js/slideShow.js') }}"></script>
    @endsection
@endsection