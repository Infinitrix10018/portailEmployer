@extends('layouts.app')
@section('title', "V3R voir les fournisseurs")
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pageAContacter.css') }}">
@show
@section('js')
    <script src="{{ asset('js/pageListeFournisseursEtat.js') }}"></script>
    <script>
        const searchUrl = "{{ route('VoirListeFournisseur.search') }}";
    </script>
@endsection
@section('content')

    <div class="container-xxl">
        <form id="listsForm" action="{{ route('VoirFiche.search') }}" method="get">
            <div class="row">
                <div class="col-sm-9">
                    <label for="rechercheFournisseur">recherche fournisseur</label> 
                    <input type="text" id="rechercheFournisseur" name="fournisseur" class="form-control">
                    <div id="fourniSuggestions" class="suggestions-container"></div>
                </div>
                <div class="col-sm-3">
                    <div style="text-align:center">
                    <button class="button" onclick="submitLists()">recherche le fournisseur</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        $('#rechercheFournisseur').on('keyup', function() {
                let query = $(this).val();
                
                if (query.length > 1) { // Start searching after two characters
                    $.ajax({
                        url: '{{ route("recherche.fournisseur") }}', // Replace with your actual route
                        method: 'GET',
                        data: { search: query },
                        success: function(data) {
                            let suggestionsContainer = $('#fourniSuggestions');
                            suggestionsContainer.empty(); // Clear previous suggestions

                            // Populate the suggestions container with results
                            data.forEach(function(item) {
                                suggestionsContainer.append(`<div class="suggestion-item">${item.nom_entreprise}</div>`);
                            });

                            // Add a click event to each suggestion item
                            $('.suggestion-item').on('click', function() {
                                $('#rechercheFournisseur').val($(this).text()); // Set the input value
                                suggestionsContainer.empty(); // Clear suggestions
                            });
                        }
                    });
                } else {
                    $('#fourniSuggestions').empty(); // Clear suggestions if query is too short
                }
            });     
    </script>  


    <div class="container-xxl" id="searchResultsContainer">
        <h2>    
            Faite une recherche pour voir des fournisseurs.
        </h2>
    </div>

    <script>
            async function sendData(value) {
                try {
                    const response = await fetch('/SupprimerAContacter', {
                        method: 'POST',
                        body: JSON.stringify({ value }),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    const result = await response.json();
                    if (result.success) {
                        window.location.href = '/VoirAContacter';
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


