<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class roomsController extends Controller
{
    public function index(){
        return view('hotel.rooms.rooms');
    }
}
