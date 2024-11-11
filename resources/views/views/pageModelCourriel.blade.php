@extends('layouts.app')
    @section('title',"V3R Fournisseur")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageModeleCourriel.css') }}">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')

                    <div class="container-xxl">
                            <div class="col-md-7">
                                <label for="idNom">Nom:</label>
                                <input type="text" class="form-control" id="idNom">

                                <label for="idObjet">Objet:</label>
                                <input type="text" class="form-control" id="idObjet">

                                <label for="idMessage">Message:</label>
                                <textarea type="text" class="form-control" id="idMessage"></textarea>
                            </div>

                            <div class="col-md-5">
                            <label for="modeles">Modèles existants:</label>
                            
                            <select id="idModele" name="modele" class="form-select" required>
                                    <option value="Default"></option>
                                    @foreach($modelCourriel as $modelCourriel)
                                        <option value="{{ $modelCourriel->nom_courriel }}">{{ $modelCourriel->nom_courriel }}</option>
                                    @endforeach
                            </select>

                                <div class="row">
                                    
                                <a href="{{url('/AjouterModelCourriel')}}"> 
                                    <button type="button" class="button" id="idBoutonAjouter">Ajouter un modele</button>
                                </a>

                                <a href="{{url('/ModifierModelCourriel')}}"> 
                                    <button type="button" class="button" id="idBoutonModifier">Modifier un modele existant</button>
                                </a>

                                <a href="{{url('/SupprimerModelCourriel')}}"> 
                                    <button type="button" class="button" id="idBoutonSupprimer">Supprimer un modele existant</button>
                                </a>

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