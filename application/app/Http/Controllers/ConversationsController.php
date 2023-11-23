<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversationsController extends Controller
{
    public function show()
    {
        return view('pages.conversations.conversations');
    }

    public function settings()
    {
        return view('pages.conversations.settings');}
}
