<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionConnection;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommisController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ModelCourrielController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModStatusController;
use App\Http\Controllers\ModInfoController;
use App\Http\Controllers\ModContactController;


//partie pour admin (va être dans un groupe de Route plus tard.)

 Route::get('/ModifierModelCourriel',
 function () {return view('views/pageModifierModelCourriel');})->name("ModifierModelCourriel");

 Route::get('/SupprimerModelCourriel',
 function () {return view('views/pageSupprimerModelCourriel');})->name("SupprimerModelCourriel");
 
Route::get('/ChangementRole', 
[UserController::class, 'index'])->name("ChangementRole");

Route::post('/user/updateRoles', [UserController::class, 'updateRoles'])->name('user.updateRoles');

Route::post('/ajouterModeleCourriel', [ModelCourrielController::class, 'store'])->name('modelCourriel.store');

Route::get('/ModifierModelCourriel', [ModelCourrielController::class, 'showModifierForm']);

Route::post('/updateModele', [ModelCourrielController::class, 'updateModele'])->name('updateModele');

Route::get('/users', 
[UserController::class, 'index']);

Route::get('/ModelCourriel',
[ModelCourrielController::class, 'listeModelCourriel'])->name("listeModelCourriel");

Route::get('/Parametres',
 function () {return view('views/pageParametres');})->name("Parametres");


Route::get('/SetSessionFicheFournisseur/{id}',
[FournisseurController::class, 'setSession'])->name("SetSessionFicheFournisseur");

Route::get('/VoirFicheFournisseur',
[FournisseurController::class, 'showFiche'])->name("VoirFicheFournisseur");

//route de recherche ci-dessous
Route::get('/VoirFiche/searchx', 
[FournisseurController::class, 'searchX'])->name('VoirFiche.search_x');


Route::get('/PageInscriptionsLicences',
 function () {return view('views/pageInscriptionsLicences');})->name("InscriptionLicences");

Route::get('/',
 function () {return view('views/pageConnexionEmployer');})->name("ConnexionEmployer");

Route::get('/login',function () {return view('views/pageConnexionEmployer');})->name("ConnexionEmployerUhOh");//don`t touch the tape
Route::post('/login',[GestionConnection::class, 'login'])->name('login');

//tous role non fournisseur
Route::group(['middleware' => [ \App\Http\Middleware\PreventBackHistory::class,
'auth:sanctum', \App\Http\Middleware\RoleMiddleware::class.':Administrateur,Responsable,Commis']],
 function () {

    Route::get('/Logout', [GestionConnection::class, 'Logout'])->name('Logout');
    Route::get('/VoirFiche',[FournisseurController::class, 'show'])->name("VoirFiche");

    Route::get('/VoirFiche/download/{id_document}',
    [FournisseurController::class, 'download'])->name('VoirFiche.download');

    Route::get('/VoirFiche/search',
    [FournisseurController::class, 'search'])->name('VoirFiche.search');

});

//responsable et admin
Route::group(['middleware' => [ \App\Http\Middleware\PreventBackHistory::class,
'auth:sanctum', \App\Http\Middleware\RoleMiddleware::class.':Administrateur,Responsable']],
 function () {
    Route::get('/choixModifierFournisseur/{id}', function($id) {return view('views/pageModFournisseurChoix', ['id' => $id]);})->name("choixModifierFournisseur");
    
    Route::get('/ChangeInfoPage/{id}', [ModInfoController::class, 'index'])->name('ChangeInfoPage');
    Route::post('/ChangeInfo', [ModInfoController::class, 'ChangeInfo'])->name("ChangeInfo");

    Route::get('/ChangeStatusPage/{id}', [ModStatusController::class, 'index'])->name("ChangeStatusPage");
    Route::post('/ChangeStatus', [ModStatusController::class, 'changeStatus'])->name("ChangeStatus");

    Route::get('/ChangeContactPage/{id}', [ModContactController::class, 'index'])->name('ChangeContactPage');
    Route::post('/ChangeContact', [ModContactController::class, 'ChangeContact'])->name("ChangeContact");
});

// Route pour les recherches

Route::get('/recherche/ville', [FournisseurController::class, 'rechercheVille'])->name('recherche.ville');
Route::get('/recherche/region', [FournisseurController::class, 'rechercheRegion'])->name('recherche.region');
Route::get('/recherche/licence', [FournisseurController::class, 'rechercheLicences'])->name('recherche.licence');
Route::get('/recherche/code', [FournisseurController::class, 'rechercheCodes'])->name('recherche.code');
