@extends('layouts.app')
    @section('title',"V3R Fournisseur")
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/pageChangementRole.css') }}">
    @show
    <!-- Needs to be adapted for bigger and smaller screens !-->
    
    @section('content')

                <div class="container-xxl sub-bx" id="containerBlanc">
                    <div class="container-xxl">
                    <form action="{{ route('user.updateRoles') }}" method="POST">
                    @csrf
                        <div class="row">
                        @foreach ($users as $user)
                            <div class="col-md-5">
                                <label for="user_{{ $user->id }}">Utilisateur:</label>
                                <p id="user_{{ $user->id }}" class="form-control-plaintext">{{ $user->name }}</p>
                            </div>

                            <div class="col-md-5">
                                <label for="role_{{ $user->id }}">Role:</label>
                                <select id="role_{{ $user->id }}" name="roles[{{ $user->id }}]" class="form-select" required>
                                    <option value="Aucun" {{ $user->role === 'Aucun' ? 'selected' : '' }}>Aucun</option>
                                    <option value="Administrateur" {{ $user->role === 'Administrateur' ? 'selected' : '' }}>Administrateur</option>
                                    <option value="Commis" {{ $user->role === 'Commis' ? 'selected' : '' }}>Commis</option>
                                    <option value="Responsable" {{ $user->role === 'Responsable' ? 'selected' : '' }}>Responsable</option>
                                </select>
                            </div>
                        @endforeach

                            <div class="col-sm-2">
                                <div class="row">
                                    <button type="button" class="button" id="idBoutonAjouter">Ajouter</button>

                                    <button type="button" class="button" id="idBoutonSupprimer">Supprimer</button>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <button type="submit" class="button" id="idBoutonEnregistrer">Enregistrer les modifications</button>
                            </div>

                            <div class="col-sm-4">
                                <button type="button" class="button">Annuler</button>
                            </div>
                        </div>
                    </div> 
                </div>
                </form>
    
@endsection