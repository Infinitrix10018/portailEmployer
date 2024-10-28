@extends('layouts.app')
    @section('title',"V3R Fournisseur")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageParametres.css') }}">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')

        <div class="container-xxl sub-bx" id="containerBlanc">
                    <div class="container-xxl">
                        <div class="row">

                            <div class="col-md-6" id="texteh5">
                                
                                <h4>Courriel de l'approvisionnement</h4>
                                
                            </div>

                            <div class="col-md-6" id="texteBox">
                            <input type="text" class="form-control">
                            </div>

                            <div class="col-md-6" id="texteh5">
                                
                                <h4>Délai avant révision</h4>
                                
                            </div>

                            <div class="col-md-6" id="texteBox">
                            <input type="text" class="form-control">
                            </div>

                            <div class="col-md-6" id="texteh5">
                                
                                <h4>Taille maximale des fichiers joints (Mo)</h4>
                                
                            </div>

                            <div class="col-md-6" id="texteBox">
                            <input type="text" class="form-control">
                            </div>

                            <div class="col-md-6" id="texteh5">
                                
                                <h4>Courriel des finances</h4>
                                
                            </div>

                            <div class="col-md-6" id="texteBox">
                            <input type="text" class="form-control">
                            </div>

                            <div class="col-lg-7">
                                <button type="button" class="button">Enregistrer les modifications</button>
                            </div>

                            <div class="col-sm-5">
                                <button type="button" class="button">Annuler</button>
                            </div>
                        </div>
      
        </div>
    </div>
    
@endsection