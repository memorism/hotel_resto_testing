<?php

namespace App\Http\Controllers\Resto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RestoController extends Controller
{
    public function index()
    {
        return view('resto.dashboard');
    }
}
