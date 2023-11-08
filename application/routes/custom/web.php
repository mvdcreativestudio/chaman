<?php

/**----------------------------------------------------------------------------------------------------------------
 * [GROWCRM - CUSTOM ROUTES]
 * Place your custom routes or overides in this file. This file is not updated with Grow CRM updates
 * ---------------------------------------------------------------------------------------------------------------*/

// DATACENTER - Home
use App\Http\Controllers\DatacenterController;

Route::get('/datacenter', [DatacenterController::class, 'index']);


// DATACENTER - Ventas
use App\Http\Controllers\SalesController;

Route::get('/sales', [SalesController::class, 'show'])->name('sales.show');

// DATACENTER - Stock
use App\Http\Controllers\StockController;

Route::get('/stock', [StockController::class, 'show'])->name('stock.show');




 // SUMERIA - Franquicias
Route::group(['prefix' => 'franchise'], function () {
    Route::any("/search", "Franchise@getAll"); // Para obtener todas las franquicias
    Route::get("/{id}", "Franchise@get"); // Para obtener una sola franquicia por ID
    Route::post("/create", "Franchise@create"); // Para crear una nueva franquicia
    Route::post("/update/{id}", "Franchise@update"); // Para actualizar una franquicia por ID
    Route::get("/toggle/{id}", "Franchise@toggleDisable"); // Para actualizar is_disabled de una franquicia por ID
    Route::get("/remove-franchise/{id}", "Team@removeFranchiseAssociation"); // Remueve la asosiacion de un Team Member con una franquicia

});

Route::get('/franchises', 'Franchise@index')->middleware('franchiseAccess');

// SUMERIA - Objetivos

Route::group(['prefix' => 'objective'], function () {
    Route::any("/search", "ObjectiveController@getAll"); // Para obtener todos los objetivos
    Route::get("/{id}", "ObjectiveController@get"); // Para obtener un solo objetivo por ID
    Route::post("/create", "ObjectiveController@create"); // Para crear un nuevo objetivo
    Route::post("/update/{id}", "ObjectiveController@update"); // Para actualizar un objetivo por ID
    Route::get("/remove-objective/{id}", "Team@removeObjectiveAssociation"); // Remueve la asosiacion de un Team Member con un objetivo
    Route::get("/destroy/{id}", "ObjectiveController@destroy"); // Para eliminar un objetivo por ID
    

});

Route::post('/update-progress-for-all-objectives', 'ObjectiveController@updateProgressForAllObjectives'); // Ruta para recargar objetivos hasta que esté el Cron
Route::get('/objectives', 'ObjectiveController@index');
Route::get('/objectives/{id}', 'ObjectiveController@show');
Route::get('/objective/edit/{id}', 'ObjectiveController@showEditModal');

//SUMERIA - Detalles Objetivos - Provisorio

use App\Http\Controllers\ObjectiveDetailController;

Route::get('/objective-detail', [ObjectiveDetailController::class, 'show'])->name('objective-detail');





