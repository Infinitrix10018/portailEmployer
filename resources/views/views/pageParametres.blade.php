@extends('layouts.app')
    @section('title',"V3R Fournisseur")
    @section('css')
        <link rel="stylesheet" href="">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')

    <div class="container-xxl">
        <div class="container-xxl" id="containerWithBorder">
        <div class="container-xxl sub-bx">
                    <div class="container-xxl">
                        <div class="row">

                            <div class="col-md-6">
                                
                                <h3>Courriel de l'approvisionnement</h3>
                                
                            </div>

                            <div class="col-md-6">
                            <input type="text" class="form-control" value="placeholder">
                            </div>

                            <div class="col-md-6">
                                
                                <h3>Délai avant révision</h3>
                                
                            </div>

                            <div class="col-md-6">
                            <input type="text" class="form-control" value="placeholder2">
                            </div>

                            <div class="col-md-6">
                                
                                <h3>Taille maximale des fichiers joints (Mo)</h3>
                                
                            </div>

                            <div class="col-md-6">
                            <input type="text" class="form-control" value="placeholder3">
                            </div>

                            <div class="col-md-6">
                                
                                <h3>Courriel des finances</h3>
                                
                            </div>

                            <div class="col-md-6">
                            <input type="text" class="form-control" value="placeholder4">
                            </div>

                            <div class="col-lg-9">
                                <button type="button" class="button">Enregistrer les modifications</button>
                            </div>

                            <div class="col-sm-3">
                                <button type="button" class="button">Annuler</button>
                            </div>
                        </div>
                    </div> 
                </div>
      
        </div>
    </div>
    
@endsection