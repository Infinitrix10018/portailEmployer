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

    <!--
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    -->

    <form action="{{ route('ChangeInfo', ['id' => request('id')]) }}" method="POST" enctype="multipart/form-data" onsubmit="logToConsole()">
    @csrf
    <div class="container-xxl">
        <div class="container-xxl" id="containerWithBorder">
            <h1>Information</h1>

            <div class="edit-info">
                <p id="text-NEQ" data-field="NEQ">Numéro d'entreprise du Québec: {{ $fournisseur->NEQ }}</p>
                <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="NEQ" onclick="makeEditable(this)">
            </div>

            <div class="edit-info">
                <p id="text-nom_entreprise" data-field="nom_entreprise">Nom de l'entreprise: {{ $fournisseur->nom_entreprise }}</p>
                <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="nom_entreprise" onclick="makeEditable(this)">
            </div>

            <div class="edit-info">
                <p id="text-email" data-field="email">Adresse courriel: {{ $fournisseur->email }}</p>
                <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="email" onclick="makeEditable(this)">
            </div>
        </div>

        <div class="container-xxl">
            <h1>Coordonnées</h1>
            <div class="container-xxl" id="containerWithBorder">
                <h1>Adresse</h1>
                <div class="row">
                    <div class="edit-info">
                        <p id="text-no_rue" data-field="no_rue">No. civique: {{ $fournisseur->no_rue }}</p>
                        <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="no_rue" onclick="makeEditable(this)">
                    </div>

                    <div class="edit-info">
                        <p id="text-rue" data-field="rue">Rue: {{ $fournisseur->rue }}</p>
                        <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="rue" onclick="makeEditable(this)">
                    </div>

                    <div class="edit-info">
                        <p id="text-no_bureau" data-field="no_bureau">Bureau: {{ $fournisseur->no_bureau }}</p>
                        <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="no_bureau" onclick="makeEditable(this)">
                    </div>

                    <div class="edit-info">
                        <p id="text-ville" data-field="ville">Ville: {{ $fournisseur->ville }}</p>
                        <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="ville" onclick="makeEditable(this)">
                    </div>

                    <div class="edit-info">
                        <p id="text-province" data-field="province">Province: {{ $fournisseur->province }}</p>
                        <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="province" onclick="makeEditable(this)">
                    </div>

                    <div class="edit-info">
                        <p id="text-no_region_admin" data-field="no_region_admin">Regions administratives: {{ $fournisseur->region ? $fournisseur->region->no_region : 'aucune region administrative' }} - {{ $fournisseur->region ? $fournisseur->region->nom_region : '' }}</p>
                        <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="no_region_admin" onclick="makeEditable(this)">
                    </div>

                    <div class="edit-info">
                        <p id="text-code_postal" data-field="code_postal">Code postal: {{ $fournisseur->code_postal }}</p>
                        <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="code_postal" onclick="makeEditable(this)">
                    </div>
                </div>

                <div class="edit-info">
                    <p id="text-site_internet" data-field="site_internet">Site internet: {{ $fournisseur->site_internet }}</p>
                    <img src="{{ asset('img/edit.svg') }}" width="25" height="25" alt="Logo Edit" class="edit-icon" data-field="site_internet" onclick="makeEditable(this)">
                </div>
                <h2>Téléphone</h2>
                <!--
                <div class="row">
                    @foreach($phonesWithoutContact as $phone)
                        <p>Type de Téléphones: {{ $phone->type_tel }}</p>
                        <p>Téléphones: {{ $phone->no_tel }}</p>
                        <p>Poste: {{ $phone->poste_tel }}</p>
                    @endforeach
                </div>
                -->
            </div>
        </div>

        <div class="container-xxl">
            <h2>Personne ressource</h2>
            <!--
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
        -->
        </div>

        <!--
        <div class="container-xxl">
            @if($licences->isNotEmpty())
                <h2>Licences RBQ</h2>
                <div class="container-xxl" id="containerWithBorder">
                    @foreach($licences as $licence)
                        <div class="edit-info">
                            <p id="text-licence" data-field="licence">{{ $licence->sous_categorie }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        -->
        
            @if($categorieCode->isNotEmpty())
                <h2>Code UNSPSC</h2>
            <!--
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
            -->
            @endif
        </div>
    </div>
        <!--<button type="submit" class="button" id="bt-center">Changer les informations</button>-->
    </form>

@endsection