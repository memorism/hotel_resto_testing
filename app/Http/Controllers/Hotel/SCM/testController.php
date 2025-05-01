<?php

namespace App\Http\Controllers\Hotel\SCM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class testController extends Controller
{

    public function index()
    {
        return view('dashboard');
    }
}

