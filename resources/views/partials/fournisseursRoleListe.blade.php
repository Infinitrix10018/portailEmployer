@if($fournisseurs->isNotEmpty())
        <div class="container-xxl">
            <div class="row">
                <div class="col-sm-4"><h3>Nom de l'entreprise</h3></div>
                <div class="col-sm-4"><h3>Ville</h3></div>
                <div class="col-sm-4"><h3>Statu de la demande</h3></div>
            </div>
        </div>

        <div class="container-xxl">
            @foreach ($fournisseurs as $fournisseur)
                <a href="{{ route('SetSessionFicheFournisseur', ['id' => $fournisseur->id_fournisseurs]) }}" class="text-decoration-none">
                    <div class="row"> 
                        <div class="col-sm-4"><p>{{ $fournisseur->nom_entreprise }}</p></div>
                        <div class="col-sm-4"><p>{{ $fournisseur->ville }}</p></div>
                        <div class="col-sm-4"><p>{{ $fournisseur->demande->etat_demande }}</p></div>
                    </div>
                </a> 
            @endforeach
        </div>

    @else  
        <div class="container-xxl">
            <h4>
                aucune pesrone à contacter
            </h4>
        </div>
    @endif