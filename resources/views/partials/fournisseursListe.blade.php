@if($results->isNotEmpty())

    <div class="row">
        <div class="col-sm-3"><h3>Nom de l'entreprise</h3></div>
        <div class="col-sm-3"><h3>Ville</h3></div>
        <div class="col-sm-2"><h3>Status</h3></div>
        <div class="col-sm-2"><h3>licences rbq</h3></div>
        <div class="col-sm-2"><h3>services</h3></div>
    </div>

    @foreach ($results as $result)
        <a href="{{ route('SetSessionFicheFournisseur', ['id' => $result->id_fournisseurs]) }}" class="text-decoration-none">
            <div class="row"> 
                <div class="col-sm-3"><p>{{ $result->nom_entreprise }}</p></div>
                <div class="col-sm-3"><p>{{ $result->ville }}</p></div>
                <div class="col-sm-2"><p>{{ $result->etat_demande ?? 'aucun status' }}</p></div>
                <div class="col-sm-2"><p>{{ $result->nbrRbq ?? '0'}}/{{ $nbrRbqs }}</p></div>
                <div class="col-sm-2"><p>{{ $result->nbrCode ?? '0'}}/{{ $nbrCodes }}</p></div>
            </div>
        </a> 
    @endforeach
@else   
    <h4>
        Aucun résultat
    </h4>
@endif