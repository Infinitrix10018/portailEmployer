<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\GestionConnection;
use App\Http\Controllers\FicheController;
use App\Http\Controllers\MenuFournisseurController;
use App\Http\Controllers\AdminController;



//new routes

//partie pour admin (va être dans un groupe de Route plus tard.)
Route::get('/Admin/Menu',
[AdminController::class, 'index'])->name("MenuAdmin");


//old routes

Route::get('/',
 function () {return view('views/index');}); //dump page

Route::get('/Accueil',
 function () {return view('views/pageAccueil');})->name("Accueil");

Route::get('/PageInscriptionsLicences',
 function () {return view('views/pageInscriptionsLicences');})->name("InscriptionLicences");

Route::get('/ConnexionFournisseur',
 function () {return view('views/pageConnexionFournisseur');})->name("ConnexionFournisseur");



Route::post('/Login',
 [GestionConnection::class, 'Login'])->name('Login');

 /*
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/Logout', [GestionConnection::class, 'Logout'])->name('Logout');

     Route::get('/VoirFiche',
    [InscriptionController::class, 'show'])->name("VoirFiche");

    Route::get('/AjouterTelephoneForm',
    [InscriptionController::class, 'formAddPhone'])->name("AjouterTelephoneForm");
    Route::post('/AjouterTelephone',
    [InscriptionController::class, 'addPhone'])->name("AjouterTelephone");

    Route::get('/AjouterContacteForm',
    [InscriptionController::class, 'formAddPerson'])->name("AjouterContacteForm");
    Route::post('/AjouterContacte',
    [InscriptionController::class, 'addPerson'])->name("AjouterContacte");

    

    

    //Route::get('/MenuFournisseur', function () {return view('views/pageMenuFournisseur');})->name("MenuFournisseur");

    Route::get('/MenuFournisseur',
    [MenuFournisseurController::class, 'index'])->name("MenuFournisseur");

    Route::get('/AjoutFinances',
    [FinanceController::class, 'index'])->name("AjoutFinances");
    Route::post('/AjoutFinances',
    [FinanceController::class, 'store'])->name('Finance.store');

    

});
*/

// début section pour les routes inscriptions
/*
Route::get('/Inscription',
[InscriptionController::class, 'index'])->name('Inscription');

Route::post('/Inscription',
[InscriptionController::class, 'store'])->name('Inscription.store');

Route::get('/Inscription/search',
[InscriptionController::class, 'search'])->name('Inscription.search');

Route::get('/Inscription/searchLicencesRBQ', 
[InscriptionController::class, 'searchRBQ'])->name('inscriptions.search_rbq');

Route::get('/Inscription/searchCodeUNSPSC', 
[InscriptionController::class, 'searchUNSPSC'])->name('inscriptions.search_unspsc');
*/
// fin section pour les routes inscriptions

/*
// vrai route ci-dessous
Route::get('/',
function () {return view('views/index');})->name("dump");

Route::get('/Accueil',
function () {return view('views/pageAccueil');})->name("Accueil");

Route::post('/Login',
 [GestionConnection::class, 'Login'])->name('Login');

 Route::get('/Admin/Menu', 
 [AdminController::class, 'menu'])->name('MenuAdmin');

 Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    //route pour admin seuleument
    
    Route::get('/MenuAdmin', 
    [AdminController::class, 'menu'])->name('MenuAdmin');

});

Route::middleware(['role:admin'])->get('/test-role', function () {
    return 'Role middleware passed!';
});

Route::middleware(['auth:sanctum', 'role:responsable'])->group(function () {
    //route pour responsable seuleument

});

Route::middleware(['auth:sanctum', 'role:commis'])->group(function () {
    //route pour commis seuleument

});


Route::middleware(['auth:sanctum', 'role:admin,responsable'])->group(function () {
    //route pour admin et responsable seuleument

});


Route::middleware(['auth:sanctum'])->group(function () {
    //route differente selon le role
    
});

// fin vrai route




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