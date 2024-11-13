@extends('layouts.app')
    @section('title',"Modifier Fiches")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageInscription.css') }}">
    @show
    @section('js')
        <script src="{{ asset('js/pageInscription.js') }}"></script>
    @endsection
    @section('content')

    <!-- Add content here!
         https://tablericons.com/ for icons
    -->
    <form action="{{ route('ChangeInfo', ['id' => request('id')]) }}" method="POST" enctype="multipart/form-data" onsubmit="logToConsole()">
    @csrf
        <div class="container-xxl">
            <div class="container-xxl" id="containerWithBorder">
                <h1>Information</h1>

                <p>Numéro d'entreprise du Québec: {{ $fournisseur->NEQ }} </p>      <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">
                
                <p>Nom de l'entreprise: {{ $fournisseur->nom_entreprise }} </p>     <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">
                
                <p>Adresse courriel: {{ $fournisseur->email }} </p>                 <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">
        
            </div>

            <div class="container-xxl">
                <h1>Coordonnées</h1>
                <div class="container-xxl" id="containerWithBorder">
                    <h1>Adresse</h1>
                    <div class="row">
                        <p>No. civique: {{ $fournisseur->no_rue }} </p>             <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">

                        <p>Rue: {{ $fournisseur->rue }} </p>                        <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">

                        <p>Bureau:{{ $fournisseur->no_bureau }} </p>                <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">
                            
                        <p>Ville: {{ $fournisseur->ville }} </p>                    <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">
                            
                        <p>Province: {{ $fournisseur->province }} </p>              <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">

                        <p>Regions administratives: 
                            {{ $fournisseur->region ? $fournisseur->region->no_region : 'aucune region administrative' }} - 
                            {{ $fournisseur->region ? $fournisseur->region->nom_region : '' }} </p>
                            
                        <p>Code postal: {{ $fournisseur->code_postal }} </p>        <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">
                    </div>

                    <p>Site internet: {{ $fournisseur->site_internet }} </p>        <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">
                    
                    <h2>Téléphone</h2>
                    <div class="row">
                        @foreach($phonesWithoutContact  as $phone)
                            <p>Type de Téléphones: {{ $phone->type_tel }}</p> 
                            <p>Téléphones: {{ $phone->no_tel }}</p>
                            <p>Poste: {{ $phone->poste_tel }}</p>
                        @endforeach
                    </div>
                </div> 
            </div> 
            

            <div class="container-xxl">
                <h2>Personne ressource</h2>
                <div class="container-xxl" id="containerWithBorder">
                    <div class="contact-info">
                        @foreach($fournisseur->personne_ressources as $contact)
                            <div class="contact row">
                                <p>Prenom du contact: {{ $contact->prenom_contact }}</p>    <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">
                                <p>Nom du contact: {{ $contact->nom_contact }}</p>          <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">
                                <p>Fonction du contact: {{ $contact->fonction }}</p>        <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">

                                @foreach($contact->telephones as $phone)
                                    <p>Type de téléphone: {{ $phone->type_tel }}</p>
                                    <p>Numéro de téléphone: {{ $phone->no_tel }}</p>
                                    <p>poste du téléphone: {{ $phone->poste_tel }}</p>
                                @endforeach

                                <p class="col-md-6">Adresse courriel: {{ $contact->email_contact }}</p> <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="container-xxl">
                @if($licences->isNotEmpty())
                    <h2>Licences RBQ</h2>
                    <div class="container-xxl" id="containerWithBorder">
                        @foreach($licences as $licence)
                            <p>{{ $licence->sous_categorie }}</p>
                        @endforeach
                    </div>
                @endif

                @if($categorieCode->isNotEmpty())
                    <h2>Code UNSPSC</h2>
                    <div class="container-xxl" id="containerWithBorder">
                        @foreach($categorieCode as $section1 => $classCategories)
                            <h3>{{ $section1 }}</h3>
                            @foreach($classCategories as $section2 => $codeUnspscs)
                                <h5>{{ $section2 }}</h5>
                                <ul>
                                    @foreach($codeUnspscs as $codeUnspsc)
                                        <li class="licence-item" data-id="{{ $codeUnspsc->id_code_unspsc }}">
                                            {{ $codeUnspsc->precision_categorie }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endforeach
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <button type="submit" class="button" id="idSubmit">Changer les informations</button>
    </form>

@endsection