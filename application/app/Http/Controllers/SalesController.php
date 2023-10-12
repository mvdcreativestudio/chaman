<?php

// app/Http/Controllers/SalesController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function show()
    {
        return view('pages.sales.sales');
    }
}

