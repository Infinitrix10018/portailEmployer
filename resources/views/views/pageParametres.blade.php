@extends('layouts.app')
    @section('title',"V3R Fournisseur")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageParametres.css') }}">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')

        <div class="container-xxl sub-bx" id="containerBlanc">
                    <div class="container-xxl">
                    <form method="POST" action="{{ route('updateParametre') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6" id="texteh5">
                                
                                <h4>Courriel de l'approvisionnement</h4>
                                
                            </div>

                            <div class="col-md-6" id="texteBox">
                            <input type="text" class="form-control" id="idCourriel" value="{{ $courriel->valeur_parametre ?? '' }}" name="courriel">
                            </div>

                            <div class="col-md-6" id="texteh5">
                                
                                <h4>Délai avant révision</h4>
                                
                            </div>

                            <div class="col-md-6" id="texteBox">
                            <input type="text" class="form-control" id="idDelai" value="{{ $delai->valeur_parametre ?? '' }}" name="valeur">
                            </div>

                            <div class="col-md-6" id="texteh5">
                                
                                <h4>Taille maximale des fichiers joints (Mo)</h4>
                                
                            </div>

                            <div class="col-md-6" id="texteBox">
                            <input type="number" class="form-control" id="idTaille" value="{{ $tailleFichier->valeur_parametre ?? '' }}" name="tailleFichier">
                            </div>

                            <div class="col-md-6" id="texteh5">
                                
                                <h4>Courriel des finances</h4>
                                
                            </div>

                            <div class="col-md-6" id="texteBox">
                            <input type="text" class="form-control" id="idCourrielFinance" value="{{ $courrielFinance->valeur_parametre ?? '' }}" name="courrielFinance">
                            </div>

                            <div class="col-lg-7">
                                <button type="submit" class="button">Enregistrer les modifications</button>
                            </div>

                            <div class="col-sm-5">
                                <button type="button" class="button">Annuler</button>
                            </div>
                        </div>
                    </form>
      
        </div>
    </div>
    
@endsection