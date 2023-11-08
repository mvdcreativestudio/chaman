<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ObjectiveDetailController extends Controller
{
    public function show()
    {
        return view('pages.objective-detail.objective-detail');
    }
}
