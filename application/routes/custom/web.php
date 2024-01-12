<?php

use App\Http\Controllers\DatacenterController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WhatsApp;
use App\Http\Controllers\ExternalAPIController;
use App\Http\Controllers\ObjectiveDetailController;
use App\Http\Controllers\ConversationsController;
use App\Http\Controllers\Franchise;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\ApiImportController;


// DATACENTER

Route::get('/datacenter', [DatacenterController::class, 'index']);
Route::get('/sales', [SalesController::class, 'show'])->name('sales.show');
Route::get('/stock', [StockController::class, 'show'])->name('stock.show');
Route::get('/datacenternuevo', [DatacenterController::class, 'datacenterNuevo'])->name('datacenter.nuevo');


// Franquicias
Route::group(['prefix' => 'franchise'], function () {
    Route::any("/search", "Franchise@getAll"); // Para obtener todas las franquicias
    Route::get("/{id}", "Franchise@get"); // Para obtener una sola franquicia por ID
    Route::post("/create", "Franchise@create"); // Para crear una nueva franquicia
    Route::post("/update/{id}", "Franchise@update"); // Para actualizar una franquicia por ID
    Route::get("/toggle/{id}", "Franchise@toggleDisable"); // Para actualizar is_disabled de una franquicia por ID
    Route::get("/remove-franchise/{id}", "Team@removeFranchiseAssociation"); // Remueve la asosiacion de un Team Member con una franquicia

});

Route::get('/franchises', 'Franchise@index')->middleware('franchiseAccess');

//Objetivos

Route::group(['prefix' => 'objective'], function () {
    Route::any("/search", "ObjectiveController@getAll"); // Para obtener todos los objetivos
    Route::get("/{id}", "ObjectiveController@get"); // Para obtener un solo objetivo por ID
    Route::post("/create", "ObjectiveController@create"); // Para crear un nuevo objetivo
    Route::post("/update/{id}", "ObjectiveController@update"); // Para actualizar un objetivo por ID
    Route::get("/remove-objective/{id}", "Team@removeObjectiveAssociation"); // Remueve la asosiacion de un Team Member con un objetivo
    Route::get("/destroy/{id}", "ObjectiveController@destroy"); // Para eliminar un objetivo por ID
    

});


Route::get('/objective-detail', [ObjectiveDetailController::class, 'show'])->name('objective-detail');
Route::post('/update-progress-for-all-objectives', 'ObjectiveController@updateProgressForAllObjectives'); // Ruta para recargar objetivos hasta que esté el Cron
Route::get('/objectives', 'ObjectiveController@index');
Route::get('/objectives/{id}', 'ObjectiveController@show');
Route::get('/objective/edit/{id}', 'ObjectiveController@showEditModal');


// Whatsapp

Route::group(['prefix' => 'whatsapp'], function () {
    Route::get('/send', 'WhatsApp@sendMessage')->name('whatsapp.send');
    Route::get('/webhook', 'WhatsApp@webhook')->name('whatsapp.webhook.get');
    Route::post('/webhook', 'WhatsApp@recibe')->name('whatsapp.webhook.post');
    Route::get('/business/whatsapp-accounts', 'WhatsApp@getOwnedWhatsAppBusinessAccounts')->name('business.whatsapp.accounts');
    Route::get('/phone-numbers/{whatsAppBusinessAccountId}', 'WhatsApp@getPhoneNumbers')->name('whatsapp.phone.numbers');
    Route::post('/update-meta-business-id', 'WhatsApp@updateMetaBusinessId')->name('whatsapp.update.meta.business.id');
    Route::post('/update-admin-token', 'WhatsApp@updateAdminToken')->name('whatsapp.update.admin.token');
    Route::post('/associate-phone', 'WhatsApp@associatePhoneNumberWithFranchise')->name('whatsapp.associate.phone');
    Route::post('/disassociate/{phone_id}', 'WhatsApp@disassociatePhoneNumber')->name('whatsapp.disassociate');
});

// API Import

Route::group(['prefix' => 'api-import'], function () {
    Route::get('/clientes', 'ExternalAPIController@getClientes');
    Route::get('/productos', 'ExternalAPIController@getProductos');
    Route::get('/proveedores', 'ExternalAPIController@getProveedores');
    Route::get('/ventas', 'ExternalAPIController@getVentas');
});

// SALES

Route::get('/sales', [ExternalAPIController::class, 'showSales'])->name('sales.show');

//PEDIDOS RRSS / Conversaciones

Route::get('/conversations', [ConversationsController::class, 'show'])->name('conversations.show');
Route::get('/conversations/settings', [ConversationsController::class, 'settings'])->name('conversations.settings');







