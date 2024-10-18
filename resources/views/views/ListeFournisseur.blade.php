@extends('layouts.app')
    @section('title',"V3R Fournisseur Login")
    @section('css')
        <link rel="stylesheet" href="">
    @show
    @section('js')
        <script src=""></script>
    @endsection
    @section('content')

    @foreach ($fournisseurs as $fournisseur)
        <form action="{{ route('people.show') }}" method="POST" class="person-card">
            @csrf <!-- Include CSRF token -->
            <input type="hidden" name="id" value="{{ $fournisseur->id }}">
            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                <div class="row">
                    <h3 class="col-lg-6">{{ $fournisseur->nom_entreprise }}</h3>
                    <h3 class="col-lg-6">{{ $fournisseur->ville }}</h3>
                </div>
            </button>
        </form>
    @endforeach

@endsection