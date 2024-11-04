<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionConnection;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommisController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\UserController;




//new routes

//partie pour admin (va être dans un groupe de Route plus tard.)

Route::get('/ModelCourriel',
 function () {return view('views/pageModelCourriel');})->name("ModelCourriel");
 
Route::get('/ChangementRole', 
[UserController::class, 'index'])->name("ChangementRole");

Route::post('/user/updateRoles', [UserController::class, 'updateRoles'])->name('user.updateRoles');

Route::get('/users', 
[UserController::class, 'index']);


Route::get('/Parametres',
 function () {return view('views/pageParametres');})->name("Parametres");


//test route


// routes pour voir les fiches


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


 Route::group(['middleware' => [ \App\Http\Middleware\PreventBackHistory::class,'auth:sanctum', \App\Http\Middleware\RoleMiddleware::class.':Administrateur,Responsable,Commis']], function () {
    Route::get('/Logout', [GestionConnection::class, 'Logout'])->name('Logout');
    Route::get('/VoirFiche',[FournisseurController::class, 'show'])->name("VoirFiche");

    
    
    
});

 


/*
// Different routes depending on role
// Admin Routes
Route::middleware(['auth:sanctum', 'check.role:admin'])->group(function () {
    Route::get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('/admin/manage-users', 'AdminController@manageUsers')->name('admin.manageUsers');
});

// Editor Routes
Route::middleware(['auth:sanctum', 'check.role:editor'])->group(function () {
    Route::get('/editor/dashboard', 'EditorController@index')->name('editor.dashboard');
    Route::get('/editor/edit-content', 'EditorController@editContent')->name('editor.editContent');
});

// Viewer Routes
Route::middleware(['auth:sanctum', 'check.role:viewer'])->group(function () {
    Route::get('/viewer/dashboard', 'ViewerController@index')->name('viewer.dashboard');
    Route::get('/viewer/view-content', 'ViewerController@viewContent')->name('viewer.viewContent');
});

// Common Routes for Admin and Editor
Route::middleware(['auth:sanctum', 'check.role:admin,editor'])->group(function () {
    Route::get('/common/edit-settings', 'CommonController@editSettings')->name('common.editSettings');
});

// Different routes depending on role
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/showA', 'ContentController@showA')->middleware('check.role:admin')->name('content.showA');
    Route::get('/showB', 'ContentController@showB')->middleware('check.role:editor,viewer')->name('content.showB');
});
// fin exemple de chatgpt
*/