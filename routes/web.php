<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionConnection;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommisController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ModelCourrielController;
use App\Http\Controllers\ParametresController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModStatusController;
use App\Http\Controllers\ModInfoController;
use App\Http\Controllers\ModContactController;
use App\Http\Controllers\EmailController;


//partie pas connecté

Route::get('/Email',
 function () {return view('views/pageEmail');})->name("Email");

 Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('send.email');

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

    Route::post('/ajouterContact',
    [FournisseurController::class, 'ajouterContact'])->name('ajouterContact');

    Route::get('/VoirAContacter',
    [FournisseurController::class, 'voirFournisseurAContacter'])->name('VoirAContacter');

    Route::post('/SupprimerAContacter',
    [FournisseurController::class, 'supprimerFournisseurAContacter'])->name('SupprimerAContacter');

    Route::get('/SetSessionFicheFournisseur/{id}',
    [FournisseurController::class, 'setSession'])->name("SetSessionFicheFournisseur");

    Route::get('/VoirFicheFournisseur',
    [FournisseurController::class, 'showFiche'])->name("VoirFicheFournisseur");
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


Route::group(['middleware' => [ \App\Http\Middleware\PreventBackHistory::class,
'auth:sanctum', \App\Http\Middleware\RoleMiddleware::class.':Administrateur']],
 function () {
    
    Route::get('/Parametres', 
    [ParametresController::class, 'index'])->name("pagesParametres");

    Route::get('/ModelCourriel',
    [ModelCourrielController::class, 'listeModelCourriel'])->name("listeModelCourriel");

    Route::get('/users', 
    [UserController::class, 'index'])->name("users");

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

    Route::post('/updateParametre', [ParametresController::class, 'updateParametre'])->name('updateParametre');


});

Route::get('/recherche/ville', [FournisseurController::class, 'rechercheVille'])->name('recherche.ville');
Route::get('/recherche/region', [FournisseurController::class, 'rechercheRegion'])->name('recherche.region');
Route::get('/recherche/licence', [FournisseurController::class, 'rechercheLicences'])->name('recherche.licence');
Route::get('/recherche/code', [FournisseurController::class, 'rechercheCodes'])->name('recherche.code');

Route::get('/pageTest', [FournisseurController::class, 'pageTest'])->name('pageTest');
Route::get('/import-xml', [FournisseurController::class, 'importXml'])->name('import.xml');
Route::get('/import-codes', [FournisseurController::class, 'importCodes'])->name('import.codesd');