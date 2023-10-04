<?php

/**----------------------------------------------------------------------------------------------------------------
 * [GROWCRM - CUSTOM ROUTES]
 * Place your custom routes or overides in this file. This file is not updated with Grow CRM updates
 * ---------------------------------------------------------------------------------------------------------------*/

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

Route::get('/objectives', 'Objectives@index');