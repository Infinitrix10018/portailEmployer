@extends('layouts.app')
    @section('title',"V3R Fournisseur")
    @section('css')
        <link rel="stylesheet" href="">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')

                <div class="container-xxl sub-bx">
                    <div class="container-xxl">
                        <div class="row">

                            <div class="col-md-5">
                                <label for="province">Utilisateur:</label>
                                <input type="text" class="form-control" value="placeholder">
                                
                            </div>

                            <div class="col-md-5">
                                <label for="role">Role:</label>
                                <select id="role" name="role" class="form-select" required>
                                    <option value="Administrateur">Administrateur</option>
                                    <option value="Commis">Commis</option>
                                    <option value="Responsable">Responsable</option>
                                    <option value="Aucun">Aucun</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="row">
                                    <button type="button" class="button">Ajouter</button>

                                    <button type="button" class="button">Supprimer</button>
                                </div>
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
    
@endsection