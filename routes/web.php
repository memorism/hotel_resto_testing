<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Hotel\BookingController;
use App\Http\Controllers\Hotel\HotelController;
use App\Http\Controllers\Hotel\roomsController;
use App\Http\Controllers\Hotel\UploadOrderController;
use App\Http\Controllers\Resto\RestoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Resto\RestoOrderController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Resto\ExcelUploadController;

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

    //route order
    Route::get('/resto/order', [RestoOrderController::class, 'index'])->name('resto.orders.index');
    Route::get('/resto/order/create', [RestoOrderController::class, 'create'])->name('resto.orders.create');
    Route::post('/resto/order', [RestoOrderController::class, 'store'])->name('resto.orders.store');
    Route::get('/resto/order/{booking}/edit', [RestoOrderController::class, 'edit'])->name('resto.orders.edit');
    Route::put('/resto/order/{booking}', [RestoOrderController::class, 'update'])->name('resto.orders.update');
    Route::get('/resto/order/{id}', [RestoOrderController::class, 'show'])->name('resto.orders.show');
    Route::delete('/resto/order/{id}', [RestoOrderController::class, 'destroy'])->name('resto.orders.destroy');

    //route upload

    Route::get('/resto/uploads', [ExcelUploadController::class, 'index'])->name('resto.dataorders.index');
    Route::get('/resto/uploads/create', [ExcelUploadController::class, 'create'])->name('resto.dataorders.create');
    Route::post('/resto/uploads', [ExcelUploadController::class, 'store'])->name('resto.dataorders.store');
    // routes/web.php
    Route::get('resto/dataorders/{uploadId}', [ExcelUploadController::class, 'show'])->name('resto.dataorders.show');


});

// hotel route
route::middleware(['auth', 'hotelMiddleware'])->group(function () {

    Route::get('/hotel/dashboard', [HotelController::class, 'index'])->name('hotel.dashboard');

    // route rooms
    Route::get('/hotel/rooms', [roomsController::class, 'index'])->name('hotel.rooms.rooms');

    // route booking
    Route::get('/hotel/booking', [BookingController::class, 'index'])->name('hotel.booking.booking');
    Route::get('/hotel/booking/create', [BookingController::class, 'create'])->name('hotel.booking.create');
    Route::post('/hotel/booking', [BookingController::class, 'store'])->name('hotel.booking.store');
    Route::get('/hotel/booking/{booking}/edit', [BookingController::class, 'edit'])->name('hotel.booking.edit');
    Route::put('/hotel/booking/{booking}', [BookingController::class, 'update'])->name('hotel.booking.update');
    Route::get('/hotel/booking/{id}', [BookingController::class, 'show'])->name('hotel.booking.show');
    Route::delete('/hotel/booking/{id}', [BookingController::class, 'destroy'])->name('hotel.booking.destroy');


    // route data booking
    Route::get('/hotel/databooking', [UploadOrderController::class, 'index'])->name('hotel.databooking.index');
    Route::get('/hotel/databooking/create', [UploadOrderController::class, 'create'])->name('hotel.databooking.create');
    Route::get('/hotel/databooking/{id}', [UploadOrderController::class, 'show']);
    Route::delete('/hotel/databooking/{id}', [UploadOrderController::class, 'destroy'])->name('hotel.databooking.destroy');
    Route::post('/hotel/databooking', [UploadOrderController::class, 'store'])->name('hotel.databooking.store');
    Route::post('/hotel/databooking/store-import', [UploadOrderController::class, 'storeAndImport'])->name('hotel.databooking.storeImport');
    Route::get('/hotel/databooking/{id}/view-upload-order', [UploadOrderController::class, 'viewUploadOrder'])->name('hotel.databooking.viewUploadOrder');
    Route::get('/hotel/databooking/{id}/edit', [UploadOrderController::class, 'edit'])->name('hotel.databooking.edit');
    Route::put('/hotel/databooking/{id}', [UploadOrderController::class, 'update'])->name('hotel.databooking.update');

});