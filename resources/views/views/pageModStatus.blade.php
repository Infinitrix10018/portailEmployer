@extends('layouts.app')
    @section('title',"Page modifier status")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageModStatus.css') }}">
    @show    
    @section('content')

                <form action="{{ route('ChangeStatus') }}" method="POST" enctype="multipart/form-data" onsubmit="logToConsole()">
                    @csrf
                    <div class="container-xxl">
                            <div class="col-md-7">
                                <label for="idComment">Commentaire:</label>
                                <textarea type="text" class="form-control" id="idComment"></textarea>
                            </div>

                            <div class="col-md-5">
                                <div class="row">
                                <div class="form-check">
                                    <label class="form-check-label" for="myCheckbox">
                                        Envoyer commentaire à fournisseur ?
                                    </label>
                                    <input class="form-check-input" type="checkbox" id="myCheckbox">
                                    
                                </div>
                                    <button type="submit" class="button" id="idBoutonActif" name="status" value="actif">Changer le statut à actif</button>
                                    <button type="submit" class="button" id="idBoutonRefusé" name="status" value="refusé">Changer le statut à refusé</button>
                                </div>
                            </div>
                    </div> 
                </form>
@endsection