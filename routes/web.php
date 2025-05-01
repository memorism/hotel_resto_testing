<?php

use App\Http\Controllers\Hotel\Finance\FinanceMigrasiController;
use App\Http\Controllers\Hotel\Finance\HotelFinanceController;
use App\Http\Controllers\Hotel\HotelControllercopy;
use App\Http\Controllers\HotelNew\HotelNewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminHotelController;
use App\Http\Controllers\Admin\AdminOkupansiHotelController;
use App\Http\Controllers\Admin\AdminOkupansiRestoController;
use App\Http\Controllers\Admin\AdminRestoController;
use App\Http\Controllers\Admin\HotelAdminController;
use App\Http\Controllers\Admin\RestoAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Hotel\HotelController;
use App\Http\Controllers\Hotel\OkupansiController;
use App\Http\Controllers\Hotel\BookingController;
use App\Http\Controllers\Hotel\RoomController;
use App\Http\Controllers\Hotel\UploadOrderController;
use App\Http\Controllers\Hotel\Frontoffice\BookingControllerFo;
use App\Http\Controllers\Hotel\Frontoffice\MigrasiController;
use App\Http\Controllers\Resto\RestoController;
use App\Http\Controllers\Resto\OccupancyController;
use App\Http\Controllers\Resto\RestoOrderController;
use App\Http\Controllers\Resto\ExcelUploadController;


// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';


route::middleware(['auth', 'userMiddleware'])->group(function () {

    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');

});

// =============================== ADMIN ROUTE ==============================
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
    Route::get('/admin/user/{id}/subusers', [UserAdminController::class, 'showSubUser'])->name('admin.user.showSubUser');

    Route::resource('resto', RestoAdminController::class)->names('admin.resto');

    Route::resource('hotel', HotelAdminController::class)->names('admin.hotel');


});
// =============================== RESTO ROUTE ==============================
Route::middleware(['auth', 'restoMiddlewareNew'])->group(function () {

    // 📊 Dashboard & Okupansi
    Route::get('/restonew/dashboard', [RestoController::class, 'index'])->name('resto.dashboard');
    Route::get('/restonew/okupansi', [OccupancyController::class, 'index'])->name('resto.okupansi');

    // 🧾 Order Management
    Route::prefix('restonew/order')->name('resto.orders.')->group(function () {
        Route::get('/', [RestoOrderController::class, 'index'])->name('index');
        Route::get('/create', [RestoOrderController::class, 'create'])->name('create');
        Route::post('/', [RestoOrderController::class, 'store'])->name('store');
        Route::get('/{order}/edit', [RestoOrderController::class, 'edit'])->name('edit');
        Route::put('/{order}/update', [RestoOrderController::class, 'update'])->name('update');
        Route::get('/{id}', [RestoOrderController::class, 'show'])->name('show');
        Route::delete('/{id}', [RestoOrderController::class, 'destroy'])->name('destroy');
    });

    // 📁 Upload Management
    Route::prefix('restonew/uploads')->name('resto.dataorders.')->group(function () {
        Route::get('/', [ExcelUploadController::class, 'index'])->name('index');
        Route::get('/create', [ExcelUploadController::class, 'create'])->name('create');
        Route::post('/store', [ExcelUploadController::class, 'store'])->name('store');
    });

    // 📄 Upload File Detail Actions
    Route::prefix('restonew')->name('resto.dataorders.')->group(function () {
        Route::get('{uploadId}/view', [ExcelUploadController::class, 'show'])->name('show');
        Route::get('{uploadId}/edit', [ExcelUploadController::class, 'edit'])->name('edit');
        Route::post('{uploadId}/update', [ExcelUploadController::class, 'update'])->name('update');
        Route::delete('{uploadId}/delete', [ExcelUploadController::class, 'destroy'])->name('destroy');
        Route::get('dataorders/{uploadId}', [ExcelUploadController::class, 'show']); // Optional duplicate
    });

});


// ============================= FRONT OFFICE ROUTE =========================
Route::middleware(['auth', 'frontoffice'])->group(function () {
    Route::prefix('frontoffice')->name('hotel.frontoffice.booking.')->group(function () {
        Route::get('/bookings', [BookingControllerFo::class, 'index'])->name('index');
        Route::get('/create', [BookingControllerFo::class, 'create'])->name('create');
        Route::post('/', [BookingControllerFo::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BookingControllerFo::class, 'edit'])->name('edit');
        Route::put('/{id}', [BookingControllerFo::class, 'update'])->name('update');
        Route::delete('/{id}', [BookingControllerFo::class, 'destroy'])->name('destroy');
    });

    // Migrasi Data Booking FO
    Route::prefix('frontoffice/migrasi')->name('hotel.frontoffice.migrasi.')->group(function () {
        Route::get('/', [MigrasiController::class, 'index'])->name('index');
        Route::get('/create', [MigrasiController::class, 'create'])->name('create');
        Route::post('/', [MigrasiController::class, 'store'])->name('store');
        Route::delete('/{id}', [MigrasiController::class, 'destroy'])->name('destroy');
    });
});

// =============================== HOTEL ROUTE ==============================
route::middleware(['auth', 'hotelMiddlewareNew'])->group(function () {

    Route::get('/hotelnew/dashboard', [HotelController::class, 'index'])->name('hotel.dashboard');
    // 📊 Okupansi Hotel
    Route::get('/hotelnew/okupansi', [OkupansiController::class, 'index'])->name('hotel.okupansi');

    // 📅 Manajemen Booking Manual
    Route::prefix('hotelnew/booking')->name('hotel.booking.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('booking');
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::post('/', [BookingController::class, 'store'])->name('store');
        Route::get('/{booking}/edit', [BookingController::class, 'edit'])->name('edit');
        Route::put('/{booking}', [BookingController::class, 'update'])->name('update');
        Route::get('/{id}', [BookingController::class, 'show'])->name('show');
        Route::delete('/{id}', [BookingController::class, 'destroy'])->name('destroy');
    });

    // 📁 Manajemen Upload Data Booking (Excel)
    Route::prefix('hotelnew/databooking')->name('hotel.databooking.')->group(function () {
        Route::get('/', [UploadOrderController::class, 'index'])->name('index');
        Route::get('/create', [UploadOrderController::class, 'create'])->name('create');
        Route::post('/', [UploadOrderController::class, 'store'])->name('store');
        Route::post('/store-import', [UploadOrderController::class, 'storeAndImport'])->name('storeImport');
        Route::get('/{id}/edit', [UploadOrderController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UploadOrderController::class, 'update'])->name('update');
        Route::get('/{id}', [UploadOrderController::class, 'show'])->name('show');
        Route::get('/{id}/view-upload-order', [UploadOrderController::class, 'viewUploadOrder'])->name('viewUploadOrder');
        Route::delete('/{id}', [UploadOrderController::class, 'destroy'])->name('destroy');
    });

    // 🛏️ Manajemen Kamar Hotel
    Route::prefix('hotelnew/kamar')->name('hotel.rooms.')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('rooms');
        Route::get('/create', [RoomController::class, 'create'])->name('create');
        Route::post('/', [RoomController::class, 'store'])->name('store');
        Route::get('/{room}/edit', [RoomController::class, 'edit'])->name('edit');
        Route::put('/{room}', [RoomController::class, 'update'])->name('update');
        Route::get('/{room}', [RoomController::class, 'show'])->name('show');
        Route::delete('/{room}', [RoomController::class, 'destroy'])->name('destroy');
    });

});

Route::middleware(['auth', 'financehotelMiddleware'])->group(function () {
    Route::resource('/finance', HotelFinanceController::class)->names('finance');
    Route::get('/migrasi', [FinanceMigrasiController::class, 'index'])->name('finance.migrasi.index');
    Route::get('/migrasi/create', [FinanceMigrasiController::class, 'create'])->name('finance.migrasi.create');
    Route::post('/migrasi', [FinanceMigrasiController::class, 'store'])->name('finance.migrasi.store');
    Route::delete('/migrasi/{id}', [FinanceMigrasiController::class, 'destroy'])->name('finance.migrasi.destroy');

});

Route::get('/', fn() => view('welcome'));

