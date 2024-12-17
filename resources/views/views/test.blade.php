@extends('layouts.app')
@section('title', "page test")
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pageFiches.css') }}">
@show
@section('js')
    <script src="{{ asset('js/pageListeFournisseurs.js') }}"></script>
@endsection
@section('content')

    <a href="{{ route('import.xml') }}" class="btn btn-primary">
        Import XML
    </a>

    <a href="{{ route('import.codes') }}" class="btn btn-primary">
        Import code unspsc
    </a>

@endsection
