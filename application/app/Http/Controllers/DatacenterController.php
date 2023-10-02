<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatacenterController extends Controller
{
    public function index()
    {
        // Puedes agregar lógica aquí si es necesario
        return view('pages.datacenter.datacenter');
    }
}




