@extends('layouts.app')
    @section('title',"Page modifier status")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageModStatus.css') }}">
    @show    
    @section('content')
    <div class="center-container">
        <h1>Entreprise: {{ $fournisseur->nom_entreprise }} </h1>
        <h2>Changer le statut</h2>
        
        <form action="{{ route('ChangeStatus', ['id' => request('id')]) }}" method="POST" enctype="multipart/form-data" onsubmit="logToConsole()">
            @csrf
            <div class="container-xxl">
                <div class="col-md-7">
                    <label for="comment">Commentaire:</label>
                    <textarea type="text" class="form-control" id="comment" name="comment"></textarea>
                </div>

                <div class="col-md-5">
                    <div class="row">
                        <div class="form-check">
                            <label class="form-check-label" for="myCheckbox">
                                Envoyer le commentaire au fournisseur ?
                            </label>
                            <input class="form-check-input" type="checkbox" id="myCheckbox" name="envoiCommentaire">
                        </div>
                        <button type="submit" class="button" id="idBoutonActif" name="status" value="actif">Changer le statut à actif</button>
                        <button type="submit" class="button" id="idBoutonRefusé" name="status" value="refusé">Changer le statut à refusé</button>
                        <button type="submit" class="button" id="idBoutonComment" name="status" value="comment">Changer uniquement le commentaire</button>
                    </div>
                </div>
            </div> 
        </form>
    </div>
@endsection