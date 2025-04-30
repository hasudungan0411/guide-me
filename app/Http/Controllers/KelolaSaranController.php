<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class KelolaSaranController extends Controller
{
    public Function saran()
    {
        return view('kelola_saranwisata.index');
    }
}
