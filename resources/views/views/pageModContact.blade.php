@extends('layouts.app')
    @section('title',"Modifier Fiches")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageModInfo.css') }}">
    @show
    @section('js')
        <script src="{{ asset('js/pageInscription.js') }}"></script>
        <script src="{{ asset('js/editInfo.js') }}"></script>
    @endsection
    @section('content')

    <div class="container-xxl">
        <h2>Personne ressource</h2>
        <div class="container-xxl" id="containerWithBorder">
            <div class="contact-info">
                @foreach($fournisseur->personne_ressources as $contact)
                    <div class="contact row">
                        <div class="edit-info">
                            <p id="text-prenom_contact" data-field="prenom_contact">Prenom du contact: {{ $contact->prenom_contact }}</p>
                            <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="prenom_contact" onclick="makeEditable(this)">
                        </div>
                        <div class="edit-info">
                            <p id="text-nom_contact" data-field="nom_contact">Nom du contact: {{ $contact->nom_contact }}</p>
                            <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="nom_contact" onclick="makeEditable(this)">
                        </div>
                        <div class="edit-info">
                            <p id="text-fonction" data-field="fonction">Fonction du contact: {{ $contact->fonction }}</p>
                            <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="fonction" onclick="makeEditable(this)">
                        </div>
                        <div class="edit-info">
                            <p id="text-email_contact" data-field="email_contact">Adresse courriel: {{ $contact->email_contact }}</p>
                            <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="email_contact" onclick="makeEditable(this)">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
