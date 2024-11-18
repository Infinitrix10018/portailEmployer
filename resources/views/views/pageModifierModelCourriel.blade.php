@extends('layouts.app')
    @section('title',"V3R Fournisseur")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageModeleCourriel.css') }}">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')
        @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
        @endif
                    <form method="POST" action="{{ route('updateModele') }}">
                        @csrf
                            <input type="hidden" name="id" value="{{ $model->id ?? '' }}">
                                <div class="container-xxl">
                                    <div class="col-lg-10">
                                        <label for="idNom">Nom:</label>
                                        <input type="text" class="form-control" id="idNom" name="nom" value="{{ $model->nom_courriel ?? '' }}">

                                        <label for="idObjet">Objet:</label>
                                        <input type="text" class="form-control" id="idObjet" name="objet" value="{{ $model->objet ?? '' }}">

                                        <label for="idMessage">Message:</label>
                                        <textarea class="form-control" id="idMessage" name="message">{{ $model->message ?? '' }}</textarea>
                                    </div>
                        </div> 

                        <div class="container-xxl">

                                    <div class="col-lg-9">
                                        <button type="submit" class="button" id="idBoutonEnregistrer">Enregistrer les modifications</button>
                                    </div>

                                    <div class="col-sm-1">
                                        <button type="button" class="button" id="idBoutonAnnuler">Annuler</button>
                                    </div>
                        </div>
                    </form>
    
@endsection