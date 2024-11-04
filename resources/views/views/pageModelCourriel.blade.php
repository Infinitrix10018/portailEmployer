@extends('layouts.app')
    @section('title',"V3R Fournisseur")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageModeleCourriel.css') }}">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')

                    <div class="container-xxl">
                            <div class="col-md-7">
                                <label for="idObjet">Objet:</label>
                                <input type="text" class="form-control" id="idObjet">

                                <label for="idMessage">Message:</label>
                                <input type="text" class="form-control" id="idMessage">
                            </div>

                            <div class="col-md-5">
                            <select id="idModele" name="modele" class="form-select" required>
                                    <option value="Default">Modèles</option>
                                    <option value="Accusé">Accusé de réception</option>
                                    <option value="Approbation">Approbation</option>
                                    <option value="Refus">Refus</option>
                                    <option value="Finances">Finances</option>
                                </select>

                                <div class="row">

                                <button type="button" class="button" id="idBoutonAjouter">Ajouter un modele</button>

                                <button type="button" class="button" id="idBoutonModifier">Modifier un modele</button>

                                <button type="button" class="button" id="idBoutonSupprimer">Supprimer un modele</button>

                                </div>
                            </div>
                    </div> 

                    <div class="container-xxl">

                            <div class="col-lg-11">
                                <button type="submit" class="button" id="idBoutonEnregistrer">Enregistrer les modifications</button>
                            </div>

                            <div class="col-sm-1">
                                <button type="button" class="button" id="idBoutonAnnuler">Annuler</button>
                            </div>
                    </div> 
    
@endsection