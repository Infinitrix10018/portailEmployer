@extends('layouts.app')
@section('title', "V3R voir les fournisseurs")
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pageFiches.css') }}">
@show
@section('js')
    <script>
        const searchUrl = "{{ route('VoirFiche.search') }}";
    </script>
    <script src="{{ asset('js/pageListeFournisseurs.js') }}"></script>
@endsection
@section('content')

    <div class="container-xxl">
        <div class="row">
            <div class="col-sm-3">
                <label for="rechercheRbq">licences rbq</label> 
                <input type="text" id="rechercheRbq" name="licences_rbq" class="form-control">
                <div id="rbqSuggestions" class="suggestions-container"></div>
            </div>
            <div class="col-sm-3">
                <label for="rechercheCode">service et code unspsc</label> 
                <input type="text" id="rechercheCode" name="code_unspsc" class="form-control">
                <div id="codeSuggestions" class="suggestions-container"></div>
            </div>
            <div class="col-sm-2">
                <label for="rechercheVille">ville</label> 
                <input type="text" id="rechercheVille" name="ville" class="form-control">
                <div id="villeSuggestions" class="suggestions-container"></div>
            </div>
            <div class="col-sm-2">
                <label for="rechercheRegion">region administrative</label> 
                <input type="text" id="rechercheRegion" name="region" class="form-control">
                <div id="regionSuggestions" class="suggestions-container"></div>
            </div>
            <div class="col-sm-2">
                <div style="text-align:center">
                <button class="button" onclick="addToLists()">Ajouter les champs de recherche</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            //place pour la recherche dans les rbq
            $('#rechercheRbq').on('keyup', function() {
                let query = $(this).val();
                
                if (query.length > 1) {
                    $.ajax({
                        url: '{{ route("recherche.licence") }}', // Replace with your actual route
                        method: 'GET',
                        data: { search: query },
                        success: function(data) {
                            let suggestionsContainer = $('#rbqSuggestions');
                            suggestionsContainer.empty(); // Clear previous suggestions

                            // Populate the suggestions container with results
                            data.forEach(function(item) {
                                suggestionsContainer.append(`<div class="suggestion-item">${item.sous_categorie}</div>`);
                            });

                            // Add a click event to each suggestion item
                            $('.suggestion-item').on('click', function() {
                                $('#rechercheRbq').val($(this).text()); // Set the input value
                                suggestionsContainer.empty(); // Clear suggestions
                            });
                        }
                    });
                } else {
                    $('#rbqSuggestions').empty(); // Clear suggestions if query is too short
                }
            });

            // Optional: Hide suggestions when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#rechercheRbq').length) {
                    $('#rbqSuggestions').empty();
                }
            });

            //partie pour la recherche avec les code unspsc
            $('#rechercheCode').on('keyup', function() {
                let query = $(this).val();
                
                if (query.length > 1) {
                    $.ajax({
                        url: '{{ route("recherche.code") }}',
                        method: 'GET',
                        data: { search: query },
                        success: function(data) {
                            let suggestionsContainer = $('#codeSuggestions');
                            suggestionsContainer.empty();

                            data.forEach(function(item) {
                                suggestionsContainer.append(`<div class="suggestion-item">${item.precision_categorie}</div>`);
                            });

                            $('.suggestion-item').on('click', function() {
                                $('#rechercheCode').val($(this).text());
                                suggestionsContainer.empty();
                            });
                        }
                    });
                } else {
                    $('#codeSuggestions').empty();
                }
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#rechercheCode').length) {
                    $('#codeSuggestions').empty();
                }
            });

            //partie pour la recherche pour la ville
            $('#rechercheVille').on('keyup', function() {
                let query = $(this).val();
                
                if (query.length > 0) {
                    $.ajax({
                        url: '{{ route("recherche.ville") }}',
                        method: 'GET',
                        data: { search: query },
                        success: function(data) {
                            let suggestionsContainer = $('#villeSuggestions');
                            suggestionsContainer.empty();

                            data.forEach(function(item) {
                                suggestionsContainer.append(`<div class="suggestion-item">${item.ville}</div>`);
                            });

                            // Add a click event to each suggestion item
                            $('.suggestion-item').on('click', function() {
                                $('#rechercheVille').val($(this).text());
                                suggestionsContainer.empty();
                            });
                        }
                    });
                } else {
                    $('#villeSuggestions').empty();
                }
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#rechercheVille').length) {
                    $('#villeSuggestions').empty();
                }
            });


            //recherche pour la region
            $('#rechercheRegion').on('keyup', function() {
                let query = $(this).val();

                if (query.length > 0) {
                    $.ajax({
                        url: '{{ route("recherche.region") }}',
                        method: 'GET',
                        data: { search: query },
                        success: function(data) {
                            let suggestionsContainer = $('#regionSuggestions');
                            suggestionsContainer.empty();

                            data.forEach(function(item) {
                                suggestionsContainer.append(`<div class="suggestion-item">${item.nom_region}</div>`);
                            });

                            $('.suggestion-item').on('click', function() {
                                $('#rechercheRegion').val($(this).text());
                                suggestionsContainer.empty();
                            });
                        }
                    });
                } else {
                    $('#regionSuggestions').empty();
                }
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#rechercheRegion').length) {
                    $('#regionSuggestions').empty();
                }
            });
        });
    </script>

    <div class="row"> 
        <div class="container-xxl col-sm-8" id="searchResultsContainer">
            <h2>    
                Faite une recherche pour voir des fournisseurs.
            </h2>
        </div>
        <div class="container-xxl col-sm-3">
            <div>
                <h3>Liste de licences rbq</h3>
                <ul id="listeRbq" onclick="deleteItem(event)"></ul>

                <h3>Liste des services et codes unspsc</h3>
                <ul id="listeCode" onclick="deleteItem(event)"></ul>

                <h3>Liste des villes</h3>
                <ul id="listeVille" onclick="deleteItem(event)"></ul>

                <h3>Liste des regions</h3>
                <ul id="listeRegion" onclick="deleteItem(event)"></ul>
            </div>
            <form id="listsForm" action="{{ route('VoirFiche.search') }}" method="get">
                @csrf
                <input type="hidden" name="listeRbq" id="listeRbqCacher">
                <input type="hidden" name="listeCode" id="listeCodeCacher">
                <input type="hidden" name="listeVille" id="listeVilleCacher">
                <input type="hidden" name="listeRegion" id="listeRegionCacher">
                <button type="submit" class="button" onclick="submitLists()">Faire une recherche</button>
            </form>
        </div>
    </div>

    <script>
        async function sendData(value) {
            try {
                const response = await fetch('/ajouterContact', {
                    method: 'POST',
                    body: JSON.stringify({ value }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const result = await response.json();
                if (result.success) {
                    //alert('Data saved successfully!');
                } else {
                    //alert('Error saving data!');
                } 
            }
            catch (error) {
                console.error('Error:', error);
            } 
            
        }
    </script>

@endsection
