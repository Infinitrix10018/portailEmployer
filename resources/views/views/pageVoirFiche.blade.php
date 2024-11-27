@extends('layouts.app')
    @section('title',"Voir Fiches")
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
    @if (Auth::check() && (Auth::user()->role === 'Administrateur' || Auth::user()->role === 'Responsable'))
        <a href="{{ route('choixModifierFournisseur', ['id' => $fournisseur->id_fournisseurs]) }}"><button class="button" id="idModInfo"><img src="{{ asset('img/edit.svg') }}" width="50" height="50" alt="Edit"></button></a>
    @endif

    <div class="container-xxl">
        <div class="container-xxl" id="containerWithBorder">
            <h1>Information</h1>

            <p>Numéro d'entreprise du Québec: {{ $fournisseur->NEQ }} </p>
            
            <p>Nom de l'entreprise: {{ $fournisseur->nom_entreprise }} </p>
            
            <p>Adresse courriel: {{ $fournisseur->email }} </p>
      
        </div>

        <div class="container-xxl">
            <h1>Coordonnées</h1>
            <div class="container-xxl" id="containerWithBorder">
                <h1>Adresse</h1>
                <div class="row">
                    <p class="col-sm-3">No. civique: {{ $fournisseur->no_rue }} </p>

                    <p class="col-sm-6">Rue: {{ $fournisseur->rue }} </p>

                    <p class="col-sm-3">Bureau:{{ $fournisseur->no_bureau }} </p>
                        
                    <p class="col-lg-12">Ville: {{ $fournisseur->ville }} </p>
                        
                    <p class="col-md-5">Province: {{ $fournisseur->province }} </p>

                    <p class="col-md-5">Regions administratives: 
                        {{ $fournisseur->region ? $fournisseur->region->no_region : 'aucune region administrative' }} - 
                        {{ $fournisseur->region ? $fournisseur->region->nom_region : '' }} </p>
                        
                    <p class="col-md-2">Code postal: {{ $fournisseur->code_postal }} </p>
                </div>

                <p>Site internet: {{ $fournisseur->site_internet }} </p>
                
                <h2>Téléphone</h2>
                <div class="row">
                    @foreach($phonesWithoutContact  as $phone)
                        <p class="col-md-3">Type de Téléphones: {{ $phone->type_tel }}</p> 
                        <p class="col-md-6">Téléphones: {{ $phone->no_tel }}</p>
                        <p class="col-md-3">Poste: {{ $phone->poste_tel }}</p>
                    @endforeach
                </div>
            </div> 
        </div> 
        

        <div class="container-xxl">
            <h2>Personne ressource</h2>
            <div class="container-xxl" >
                <div class="contact-info">
                    @foreach($fournisseur->personne_ressources as $contact)
                        <div class="contact row" id="containerWithBorder">
                            <p class="col-md-4">Prénom du contact: {{ $contact->prenom_contact }}</p>
                            <p class="col-md-4">Nom du contact: {{ $contact->nom_contact }}</p>
                            <p class="col-md-4">Fonction du contact: {{ $contact->fonction }}</p>

                            @foreach($contact->telephones as $phone)
                                <p class="col-md-4">Type de téléphone: {{ $phone->type_tel }}</p>
                                <p class="col-md-4">Numéro de téléphone: {{ $phone->no_tel }}</p>
                                <p class="col-md-4">Poste du téléphone: {{ $phone->poste_tel }}</p>
                            @endforeach

                             <p class="col-md-6">Adresse courriel: {{ $contact->email_contact }}</p>
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
        <div class="container-xxl">
            @if($fournisseur->commentaire && $fichiers->isNotEmpty())
                <h2>Commentaire</h2>
                <div class="container-xxl" id="containerWithBorder">
                    @if($fournisseur->demande->commentaire)
                        <h2>Votre commentaire</h2>
                        <p class="col-sm-12">Votre commentaire: {{ $fournisseur->commentaire }} </p>
                    @endif

                    @foreach ($fichiers as $fichier)
                        <p>
                            <a href="{{ route('VoirFiche.download', $fichier->id_document) }}" download>
                                {{ $fichier->nomDocument }}
                            </a>
                        </p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection