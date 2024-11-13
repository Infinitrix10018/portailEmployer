@if($results->isNotEmpty())

<div class="row">
    <div class="col-sm-3"><h3>Nom de l'entreprise</h3></div>
    <div class="col-sm-3"><h3>Ville</h3></div>
    <div class="col-sm-2"><h3>Status</h3></div>
    <div class="col-sm-2"><h3>licences rbq</h3></div>
    <div class="col-sm-2"><h3>services</h3></div>
</div>

@foreach ($fournisseurs as $fournisseur)
    <a href="{{ route('SetSessionFicheFournisseur', ['id' => $results->id_fournisseurs]) }}" class="text-decoration-none">
        <div class="row"> 
            <div class="col-sm-3"><p>{{ $results->nom_entreprise }}</p></div>
            <div class="col-sm-3"><p>{{ $results->ville }}</p></div>
            <div class="col-sm-2"><p>{{ $results->demande->etat_demande ?? 'aucun status' }}</p></div>
            <div class="col-sm-2"><p>{{ $results->licences_rbq ?? 'aucune licences demander' }}</p></div>
            <div class="col-sm-2"><p>{{ $results->code_unspsc ?? 'aucun code demander' }}</p></div>
        </div>
    </a> 
@endforeach
@else   
<h4>
    Aucun résultat
</h4>
@endif