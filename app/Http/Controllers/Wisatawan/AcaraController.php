<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcaraController extends Controller
{
    public function acara()
    {
        return view('wisatawan.acara');
    }
}
