<?php

// app/Http/Controllers/StockController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function show()
    {
        return view('pages.stock.stock');
    }
}

