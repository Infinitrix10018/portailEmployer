@if($results->isNotEmpty())

<div class="row"> 
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-3"><h3>Nom de l'entreprise</h3></div>
            <div class="col-sm-3"><h3>Ville</h3></div>
            <div class="col-sm-2"><h3>Status</h3></div>
            <div class="col-sm-2"><h3>licences rbq</h3></div>
            <div class="col-sm-2"><h3>services</h3></div>
        </div>
    </div>
    <div class="col-sm-2">
        <h3> à contacter </h3>
    </div>
</div>

@foreach ($results as $result)
    <div>
        <ul id="hoverable">
            <div class="row"> 
                <div class="col-sm-10">
                    <a href="{{ route('SetSessionFicheFournisseur', ['id' => $result->id_fournisseurs]) }}"class="text-decoration-none">
                        <div class="row"> 
                            <div class="col-sm-3"><p>{{ $result->nom_entreprise }}</p></div>
                            <div class="col-sm-3"><p>{{ $result->ville }}</p></div>
                            <div class="col-sm-2"><p>{{ $result->etat_demande ?? 'aucun status' }}</p></div>
                            <div class="col-sm-2"><p>{{ $result->nbrRbq ?? '0'}}/{{ $nbrRbqsTotal }}</p></div>
                            <div class="col-sm-2"><p>{{ $result->nbrCode ?? '0'}}/{{ $nbrCodesTotal }}</p></div>
                        </div>
                    </a> 
                </div>
                <div class="col-sm-2">
                    <button onclick="sendData('{{ $result->id_fournisseurs }}')" class="button">
                        À contacter
                    </button>
                </div>
            </div>
        </ul>
    </div>
@endforeach
@else   
    <h4>
        Aucun résultat
    </h4>
@endif
