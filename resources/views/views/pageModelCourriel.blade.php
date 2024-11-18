@extends('layouts.app')
    @section('title',"V3R Fournisseur")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageModeleCourriel.css') }}">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')

                    <div class="container-xxl">
                            <div class="col-md-7">
                                <form action="{{ route('modelCourriel.store') }}" method="POST">
                                    @csrf
                
                                    <label for="idNom">Nom:</label>
                                    <input type="text" class="form-control" id="idNom" name="nom">

                                    <label for="idObjet">Objet:</label>
                                    <input type="text" class="form-control" id="idObjet" name="objet">

                                    <label for="idMessage">Message:</label>
                                    <textarea class="form-control" id="idMessage" name="message"></textarea>

                                        <button type="submit" class="btn btn-primary" id="idBoutonAjouter">Ajouter un modele</button>
                                </form>
                            </div>

                            <div class="col-md-5">
                            <label for="modeles">Modèles existants:</label>
                            
                            <form action="{{ url('/ModifierModelCourriel') }}" method="get">
                            <select id="idModele" name="modele" class="form-select" required>
                                    @foreach($modelCourriel as $modelCourriel)
                                        <option value="{{ $modelCourriel->nom_courriel }}">{{ $modelCourriel->nom_courriel }}</option>
                                    @endforeach
                            </select>

                                    <button type="submit" class="button" id="idBoutonModifier">Modifier un modele existant</button>
                            </form>
                            
                            </div>
                    </div>
    
@endsection