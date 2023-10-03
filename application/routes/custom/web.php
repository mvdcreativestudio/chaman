<?php

// DATACENTER
use App\Http\Controllers\DatacenterController;

Route::get('/datacenter', [DatacenterController::class, 'index']);
