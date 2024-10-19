@extends('layouts.app')
    @section('title',"V3R Fournisseur Login")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/ListeFournisseurs.css') }}">
    @show
    @section('js')
        <script src=""></script>
    @endsection
    @section('content')

<!--
    <form id="searchForm">
        <label for="cities">Select Cities:</label>
        <select id="cities" name="cities[]" multiple>
            <option value="City A">City A</option>
            <option value="City B">City B</option>
            <option value="City C">City C</option>
        </select>

        <label for="jobs">Select Jobs:</label>
        <select id="jobs" name="jobs[]" multiple>
            <option value="Job A">Job A</option>
            <option value="Job B">Job B</option>
            <option value="Job C">Job C</option>
        </select>

        <button type="submit">Search</button>
    </form>
-->

    @foreach ($fournisseurs as $fournisseur)
        <form action="{{ route('VoirFicheFournisseur') }}" method="POST" class="person-card">
            @csrf <!-- Include CSRF token -->
            <div class="container-xxl">
                <input type="hidden" name="id" value="{{ $fournisseur->id_fournisseurs }}">
                <button type="submit" class="custom-button">
                    <h3 id="padding5">{{ $fournisseur->nom_entreprise }}</h3>
                    <h3 id="padding5">{{ $fournisseur->ville }}</h3>
                </button>
            </div>
        </form>
    @endforeach



@endsection