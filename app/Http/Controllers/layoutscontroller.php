<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class layoutscontroller extends Controller
{
    public function admin()
    {
        return view('layouts.admin');
    }

    public function wisatawan() 
    {
        return view('layouts.wisatawan');
    }
}
