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

    <form action="{{ route('ChangeContact', ['id' => request('id')]) }}" method="POST" enctype="multipart/form-data" onsubmit="logToConsole()">
    @csrf
        <div class="container-xxl">
            <h2>Personne ressource</h2>
            <div class="container-xxl">
                <div class="contact-info">
                    @foreach($fournisseur->personne_ressources as $contact)    
                    <p hidden id="personne-ressource-{{ $contact->id_personne_ressource }}">{{ $contact->id_personne_ressource }}</p>
                        <div class="contact row" id="containerWithBorder">
                            <div class="edit-info">
                                <p id="text-prenom_contact-{{ $contact->id_personne_ressource }}" data-field="prenom_contact">Prenom du contact: {{ $contact->prenom_contact }}</p>
                                <img data-contact-id="{{ $contact->id_personne_ressource }}" src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="prenom_contact" onclick="makeEditableContact(this)">
                            </div>
                            <div class="edit-info">
                                <p id="text-nom_contact-{{ $contact->id_personne_ressource }}" data-field="nom_contact">Nom du contact: {{ $contact->nom_contact }}</p>
                                <img data-contact-id="{{ $contact->id_personne_ressource }}"  src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="nom_contact" onclick="makeEditableContact(this)">
                            </div>
                            <div class="edit-info">
                                <p id="text-fonction-{{ $contact->id_personne_ressource }}" data-field="fonction">Fonction du contact: {{ $contact->fonction }}</p>
                                <img data-contact-id="{{ $contact->id_personne_ressource }}"  src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="fonction" onclick="makeEditableContact(this)">
                            </div>
                            <div class="edit-info">
                                <p id="text-email_contact-{{ $contact->id_personne_ressource }}" data-field="email_contact">Adresse courriel: {{ $contact->email_contact }}</p>
                                <img data-contact-id="{{ $contact->id_personne_ressource }}"  src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="email_contact" onclick="makeEditableContact(this)">
                            </div>
                            @foreach($contact->telephones as $phone)
                                <div class="edit-info">
                                    <p id="text-type_tel-{{ $contact->id_personne_ressource }}" data-field="type_tel">Type de téléphone: {{ $phone->type_tel }}</p>
                                    <img data-contact-id="{{ $contact->id_personne_ressource }}"  src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="type_tel" onclick="makeEditableContact(this)">
                                </div>
                                <div class="edit-info">
                                    <p id="text-no_tel-{{ $contact->id_personne_ressource }}" data-field="no_tel">Numéro de téléphone: {{ $phone->no_tel }}</p>
                                    <img data-contact-id="{{ $contact->id_personne_ressource }}"  src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="no_tel" onclick="makeEditableContact(this)">
                                </div>
                                <div class="edit-info">
                                    <p id="text-poste_tel-{{ $contact->id_personne_ressource }}" data-field="poste_tel">Poste du téléphone: {{ $phone->poste_tel }}</p>
                                    <img data-contact-id="{{ $contact->id_personne_ressource }}"  src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="poste_tel" onclick="makeEditableContact(this)">
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
@endsection