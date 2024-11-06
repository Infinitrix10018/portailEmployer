@extends('layouts.app')
    @section('title',"V3R Fournisseur")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageModeleCourriel.css') }}">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')

                    <div class="container-xxl">
                            <div class="col-lg-10">
                                <label for="idNom">Nom:</label>
                                <input type="text" class="form-control" id="idNom">

                                <label for="idObjet">Objet:</label>
                                <input type="text" class="form-control" id="idObjet">

                                <label for="idMessage">Message:</label>
                                <textarea type="text" class="form-control" id="idMessage"></textarea>
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
    
@endsection