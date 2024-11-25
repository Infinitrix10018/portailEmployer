@extends('layouts.app')
    @section('title',"V3R Fournisseur")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageParametres.css') }}">
    @show
    
    @section('content')
    <div class="container">
    <h1>Send a Test Email</h1>
    <form action="{{ route('send.email') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Send Email</button>
    </form>
</div>
        
    
@endsection