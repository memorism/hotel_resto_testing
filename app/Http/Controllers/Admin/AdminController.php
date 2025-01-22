<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Hitung jumlah akun hotel dan resto
        $hotelCount = User::where('usertype', 'hotel')->count();
        $restoCount = User::where('usertype', 'resto')->count();
    
        return view('admin.dashboard', compact('hotelCount', 'restoCount'));
    }
}
