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

        <form action="{{ route('AjouterTelephone') }}" method="POST" enctype="multipart/form-data" onsubmit="logToConsole()">
        @csrf
            <div class="container-xxl">
            <h1>Ajouter un numéro de téléphone</h1>
                <div class="row phone-number-group">
                    <div class="col-md-3">
                        <label for="type_tel1">Type de Téléphones</label>
                        <select id="type_tel1" name="type_tels[fournisseur]" class="form-select {{ $errors->has('type_tels.fournisseur') ? 'failure' : (old('type_tels.fournisseur') ? 'success' : '') }}" value="{{ old('type_tels.fournisseur') }}" required>
                            <option value="bureau">Bureau</option>
                            <option value="cellulaire">Célulaire</option>
                            <option value="fax">Fax</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="no_tel1">Téléphones:</label>
                        <input type="text" class="form-control {{ $errors->has('no_tel.fournisseur') ? 'failure' : (old('no_tel.fournisseur') ? 'success' : '') }}" id="no_tel1" name="no_tel[fournisseur]" value="{{ old('no_tel.fournisseur') }}" >
                    </div>

                    <div class="col-md-3">
                        <label for="poste_tel1">Poste:</label>
                        <input type="text" class="form-control {{ $errors->has('poste_tel.fournisseur') ? 'failure' : (old('poste_tel.fournisseur') ? 'success' : '') }}" id="poste_tel1" name="poste_tel[fournisseur]" value="{{ old('poste_tel.fournisseur') }}" >
                    </div>
                                    
                </div>   
            </div> 
            <div id="bt-center">
                <button type="submit" class="button">Envoyer le formulaire</button>
            </div>
    </form>

    <script>
        function logToConsole() {
            console.log('boutton \'envoyer formulaire\' cliquer ');
        }
    </script>

@endsection