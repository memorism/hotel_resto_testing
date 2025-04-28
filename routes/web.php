<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\admin\AdminHotelController;
use App\Http\Controllers\admin\AdminOkupansiHotelController;
use App\Http\Controllers\admin\AdminOkupansiRestoController;
use App\Http\Controllers\Admin\AdminRestoController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Hotel\BookingController;
use App\Http\Controllers\hotel\frontoffice\BookingControllerFo;
use App\Http\Controllers\Hotel\Frontoffice\MigrasiController;
use App\Http\Controllers\Hotel\HotelController;
use App\Http\Controllers\Hotel\OkupansiController;
use App\Http\Controllers\hotel\RoomController;
use App\Http\Controllers\Hotel\roomsController;
use App\Http\Controllers\Hotel\UploadOrderController;
use App\Http\Controllers\resto\OccupancyController;
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
    Route::get('/admin/dashboard/resto', [AdminRestoController::class, 'index'])->name('admin.resto');
    Route::get('/admin/dashboard/hotel', [AdminHotelController::class, 'index'])->name('admin.hotel');
    Route::get('/admin/okupansi/resto', [AdminOkupansiRestoController::class, 'index'])->name('admin.okupansiresto');
    Route::get('/admin/okupansi/hotel', [AdminOkupansiHotelController::class, 'index'])->name('admin.okupansihotel');
    // route user
    Route::get('/admin/user', [UserAdminController::class, 'index'])->name('admin.user.user');
    Route::get('/admin/user/create', [UserAdminController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/user', [UserAdminController::class, 'store'])->name('admin.user.store');
    Route::delete('/admin/user/{id}', [UserAdminController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('/admin/user/logo/{id}', [UserAdminController::class, 'showLogo'])->name('admin.user.logo');
    Route::get('/admin/edit/{id}', [UserAdminController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/update/{id}', [UserAdminController::class, 'update'])->name('admin.user.update');





});

// resto route
route::middleware(['auth', 'restoMiddleware'])->group(function () {

    Route::get('/resto/dashboard', [RestoController::class, 'index'])->name('resto.dashboard');
    Route::get('/resto/okupansi', [OccupancyController::class, 'index'])->name('resto.okupansi');

    //route order
    Route::get('/resto/order', [RestoOrderController::class, 'index'])->name('resto.orders.index');
    Route::get('/resto/order/create', [RestoOrderController::class, 'create'])->name('resto.orders.create');
    Route::post('/resto/order', [RestoOrderController::class, 'store'])->name('resto.orders.store');
    Route::get('/resto/order/{order}/edit', [RestoOrderController::class, 'edit'])->name('resto.orders.edit');
    Route::put('/resto/order/{order}/update', [RestoOrderController::class, 'update'])->name('resto.orders.update');
    Route::get('/resto/order/{id}', [RestoOrderController::class, 'show'])->name('resto.orders.show');
    Route::delete('/resto/order/{id}', [RestoOrderController::class, 'destroy'])->name('resto.orders.destroy');

    //route upload

    Route::get('/resto/uploads', [ExcelUploadController::class, 'index'])->name('resto.dataorders.index');
    Route::get('/resto/uploads/create', [ExcelUploadController::class, 'create'])->name('resto.dataorders.create');
    Route::post('/resto/uploads/store', [ExcelUploadController::class, 'store'])->name('resto.dataorders.store');
    Route::get('/resto/{uploadId}/view', [ExcelUploadController::class, 'show'])->name('resto.dataorders.show');
    Route::get('/resto/{uploadId}/edit', [ExcelUploadController::class, 'edit'])->name('resto.dataorders.edit');
    Route::post('/resto/{uploadId}/update', [ExcelUploadController::class, 'update'])->name('resto.dataorders.update');
    Route::delete('/resto/{uploadId}/delete', [ExcelUploadController::class, 'destroy'])->name('resto.dataorders.destroy');
    // routes/web.php
    Route::get('resto/dataorders/{uploadId}', [ExcelUploadController::class, 'show'])->name('resto.dataorders.show');


});

// hotel route
route::middleware(['auth', 'hotelMiddleware'])->group(function () {

    Route::get('/hotel/dashboard', [HotelController::class, 'index'])->name('hotel.dashboard');
    Route::get('/hotel/okupansi', [OkupansiController::class, 'index'])->name('hotel.okupansi');
    // Manager (karena Manager pakai hotelMiddleware)
    Route::get('/hotel/manage-users', [UserController::class, 'index'])->name('hotel.manage.users');


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


    //route Kamar
    Route::get('/hotel/kamar', [RoomController::class, 'index'])->name('hotel.rooms.rooms');
    Route::get('/hotel/kamar/create', [RoomController::class, 'create'])->name('hotel.rooms.create');
    Route::get('/hotel/kamar/{room}', [RoomController::class, 'show']);
    Route::delete('/hotel/kamar/{room}', [RoomController::class, 'destroy'])->name('hotel.rooms.destroy');
    Route::post('/hotel/kamar', [RoomController::class, 'store'])->name('hotel.rooms.store');
    Route::get('/hotel/kamar/{room}/edit', [RoomController::class, 'edit'])->name('hotel.rooms.edit');
    Route::put('/hotel/kamar/{room}', [RoomController::class, 'update'])->name('hotel.rooms.update');



});

// Front Office Only
Route::middleware(['auth', 'frontoffice'])->group(function () {
    Route::get('/frontoffice/bookings', [BookingControllerFo::class, 'index'])->name('hotel.frontoffice.booking.index');
    Route::get('/frontoffice/create', [BookingControllerFo::class, 'create'])->name('hotel.frontoffice.booking.create');
    Route::delete('/frontoffice/{id}', [BookingControllerFo::class, 'destroy'])->name('hotel.frontoffice.booking.destroy');
    Route::post('/frontoffice', [BookingControllerFo::class, 'store'])->name('hotel.frontoffice.booking.store');
    Route::get('/frontoffice/{id}/edit', [BookingControllerFo::class, 'edit'])->name('hotel.frontoffice.booking.edit');
    Route::put('/frontoffice/{id}', [BookingControllerFo::class, 'update'])->name('hotel.frontoffice.booking.update');
    Route::get('/frontoffice/migrasi', [MigrasiController::class, 'index'])->name('hotel.frontoffice.migrasi.index');
    Route::post('/frontoffice/migrasi', [MigrasiController::class, 'store'])->name('hotel.frontoffice.migrasi.store');
    Route::delete('/frontoffice/migrasi/{id}', [MigrasiController::class, 'destroy'])->name('hotel.frontoffice.migrasi.destroy');
    Route::get('/frontoffice/migrasi/create', [MigrasiController::class, 'create'])->name('hotel.frontoffice.migrasi.create');
});


// // Finance Only
// Route::middleware(['auth', 'finance'])->group(function () {
//     Route::resource('/hotel/transactions', TransactionController::class);
// });

