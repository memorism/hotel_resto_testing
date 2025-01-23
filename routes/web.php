<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Hotel\BookingController;
use App\Http\Controllers\Hotel\HotelController;
use App\Http\Controllers\Hotel\roomsController;
use App\Http\Controllers\Resto\RestoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/logout', function () {
    Auth::logout();  // Logout pengguna
    return redirect('/'); // Redirect ke halaman login setelah logout
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// user route
route::middleware(['auth', 'userMiddleware'])->group(function () {

    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');

});

// admin route
route::middleware(['auth', 'adminMiddleware'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // route user
    Route::get('/admin/user', [UserAdminController::class, 'index'])->name('admin.user.user');
    Route::get('/admin/user/create', [UserAdminController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/user', [UserAdminController::class, 'store'])->name('admin.user.store');
    Route::delete('/admin/user/{id}', [UserAdminController::class, 'destroy'])->name('admin.user.destroy');
    


});

// resto route
route::middleware(['auth', 'restoMiddleware'])->group(function () {

    Route::get('/resto/dashboard', [RestoController::class, 'index'])->name('resto.dashboard');

});

// hotel route
route::middleware(['auth', 'hotelMiddleware'])->group(function () {

    Route::get('/hotel/dashboard', [HotelController::class, 'index'])->name('hotel.dashboard');
    // route rooms
    Route::get('/hotel/rooms', [roomsController::class, 'index'])->name('hotel.rooms.rooms');
    Route::get('/hotel/booking', [BookingController::class, 'index'])->name('hotel.booking.booking');
    Route::get('/hotel/booking/{id}', [BookingController::class, 'show']);
    Route::delete('/hotel/booking/{id}', [BookingController::class, 'destroy'])->name('hotel.booking.destroy');


});