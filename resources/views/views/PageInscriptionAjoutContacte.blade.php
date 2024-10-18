@extends('layouts.app')
    @section('title',"V3R Fournisseur Login")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageInscription.css') }}">
    @show
    @section('js')
        <script src="{{ asset('js/pageInscription.js') }}"></script>
        <script src="{{ asset('js/form.js') }}"></script>
    @endsection
    @section('content')

    <!-- Add content here!
         https://tablericons.com/ for icons
    -->

    <script>
        const limit = 50; // Set your desired limit
    </script>

        <form action="{{ route('AjouterContacte') }}" method="POST" enctype="multipart/form-data" onsubmit="logToConsole()">
        @csrf
            <div class="container-xxl main-bx">
                <h1>Contacts</h1>
                <div id="contact">
                        <div class="row contact-group">
                            <div class="col-lg-12">
                                <label for="prenom_contact">Prénom</label>
                                <input type="text" class="form-control {{ $errors->has('prenom.personne_ressource') ? 'failure' : (old('prenom.personne_ressource') ? 'success' : '') }}" id="prenom_contact" name="prenom[personne_ressource]" value="{{ old('prenom.personne_ressource') }}" >
                            </div>

                            <div class="col-lg-12">
                                <label for="nom_contact">Nom:</label>
                                <input type="text" class="form-control {{ $errors->has('nom.personne_ressource') ? 'failure' : (old('nom.personne_ressource') ? 'success' : '') }}" id="nom_contact" name="nom[personne_ressource]" value="{{ old('nom.personne_ressource') }}">
                            </div>

                            <div class="col-lg-12">
                                <label for="fonction">Fonction:</label>
                                <input type="text" class="form-control {{ $errors->has('fonction.personne_ressource') ? 'failure' : (old('fonction.personne_ressource') ? 'success' : '') }}" id="fonction" name="fonction[personne_ressource]" value="{{ old('fonction.personne_ressource') }}" >
                            </div>

                            <div class="col-lg-12">
                                <label for="email_contact">Adresse courriel:</label>
                                <input type="text" class="form-control {{ $errors->has('email_contact.personne_ressource') ? 'failure' : (old('email_contact.personne_ressource') ? 'success' : '') }}" id="email_contact" name="email_contact[personne_ressource]" value="{{ old('email_contact.personne_ressource') }}" >
                            </div>
                        </div>
                    
                        <div class="container-xxl">
                            <div class="row contact-group-tel">
                                <div class="col-md-3">
                                    <label for="type_tel">Type de Téléphones</label>
                                    <select id="type_tel" name="type_tels[personne_ressource]" class="form-select {{ $errors->has('type_tels.personne_ressource') ? 'failure' : (old('type_tels.personne_ressource') ? 'success' : '') }}" value="{{ old('type_tels.personne_ressource') }}" required>
                                        <option value="bureau">Bureau</option>
                                        <option value="cellulaire">Célulaire</option>
                                        <option value="fax">Fax</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="no_tel1">Téléphones:</label>
                                    <input type="text" class="form-control {{ $errors->has('no_tel.personne_ressource') ? 'failure' : (old('no_tel.personne_ressource') ? 'success' : '') }}" id="no_tel_contact1" name="no_tel[personne_ressource]" value="{{ old('no_tel.personne_ressource') }}" >
                                </div>

                                <div class="col-md-3">
                                    <label for="poste_tel1">Poste:</label>
                                    <input type="text" class="form-control {{ $errors->has('poste_tel.personne_ressource') ? 'failure' : (old('poste_tel.personne_ressource') ? 'success' : '') }}" id="poste_tel_contact1" name="poste_tel[personne_ressource]" value="{{ old('no_tel.personne_ressource') }}">
                                </div>
                                    
                            </div> 
                        </div>
                </div> 
            </div>
            
            <div id="bt-center">
                <button type="submit" class="button">Envoyer le formulaire</button>
            </div>
    </form>
@endsection