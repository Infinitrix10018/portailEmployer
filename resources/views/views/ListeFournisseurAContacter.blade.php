@extends('layouts.app')
@section('title', "V3R voir les fournisseurs")
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pageAContacter.css') }}">
@show
@section('js')
    <script>
        const searchUrl = "{{ route('VoirFiche.search') }}";
    </script>
    <script src="{{ asset('js/pageListeFournisseurs.js') }}"></script>
@endsection
@section('content')

    @if($results->isNotEmpty())
        <div class="container-xxl">
            <div class="row">
                <div class="col-sm-4"><h3>Nom de l'entreprise</h3></div>
                <div class="col-sm-4"><h3>Ville</h3></div>
            </div>
        </div>

        <div class="container-xxl">
            @foreach ($results as $result)
                <div class="row"> 
                    <div class="col-sm-8">
                        <a href="{{ route('SetSessionFicheFournisseur', ['id' => $result->id_fournisseurs]) }}" class="text-decoration-none">
                            <div class="row"> 
                                <div class="col-sm-6"><p>{{ $result->nom_entreprise }}</p></div>
                                <div class="col-sm-6"><p>{{ $result->ville }}</p></div>
                                
                            </div>
                        </a> 
                    </div>
                    <div class="col-sm-4">
                         <button onclick="sendData('{{ $result->id_fournisseurs }}')" class="button">
                             Enlever le fournisseur de la liste
                         </button>
                     </div>
                </div>
            @endforeach
        </div>

    @else  
        <div class="container-xxl">
            <h4>
                aucune pesrone à contacter
            </h4>
        </div>
    @endif

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


