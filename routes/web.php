<?php

use App\Http\Controllers\Admin\AdminSharedCustomerController;
use App\Http\Controllers\Admin\AdminSubuserController;
use App\Http\Controllers\Hotel\Finance\FinanceMigrasiController;
use App\Http\Controllers\Hotel\Finance\HotelFinanceController;
use App\Http\Controllers\Hotel\SCM\HotelSupplyTransactionController;
use App\Http\Controllers\Hotel\SCM\testController;
use App\Http\Controllers\SharedCustomerController;
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
use App\Http\Controllers\Hotel\SCM\HotelSupplyController;

// ======================= AUTH & PROFILE =======================
Route::post('/logout', fn() => tap(Auth::logout(), fn() => redirect('/')));

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// ======================= USER ROUTE =======================
Route::middleware(['auth', 'userMiddleware'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
});

// ======================= ADMIN ROUTES =======================
Route::middleware(['auth', 'adminMiddleware'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/resto', [AdminRestoController::class, 'index'])->name('admin.resto');
    Route::get('/admin/dashboard/hotel', [AdminHotelController::class, 'index'])->name('admin.hotel');
    Route::get('/admin/okupansi/resto', [AdminOkupansiRestoController::class, 'index'])->name('admin.okupansiresto');
    Route::get('/admin/okupansi/hotel', [AdminOkupansiHotelController::class, 'index'])->name('admin.okupansihotel');

    // User Management
    Route::prefix('/admin/user')->group(function () {
        Route::get('/', [UserAdminController::class, 'index'])->name('admin.user.user');
        Route::get('/create', [UserAdminController::class, 'create'])->name('admin.user.create');
        Route::post('/', [UserAdminController::class, 'store'])->name('admin.user.store');
        Route::delete('/{id}', [UserAdminController::class, 'destroy'])->name('admin.user.destroy');
        Route::get('/logo/{id}', [UserAdminController::class, 'showLogo'])->name('admin.user.logo');
        Route::get('/edit/{id}', [UserAdminController::class, 'edit'])->name('admin.user.edit');
        Route::put('/update/{id}', [UserAdminController::class, 'update'])->name('admin.user.update');
    });

    // Subuser Management
    Route::prefix('/admin/subusers')->group(function () {
        Route::get('/{id}', [AdminSubuserController::class, 'index'])->name('admin.user.subuser.index');
        Route::get('/{id}/create', [AdminSubuserController::class, 'create'])->name('admin.subusers.create');
        Route::post('/{id}', [AdminSubuserController::class, 'store'])->name('admin.subusers.store');
        Route::get('/edit/{subuserId}', [AdminSubuserController::class, 'edit'])->name('admin.subusers.edit');
        Route::put('/update/{subuserId}', [AdminSubuserController::class, 'update'])->name('admin.subusers.update');
        Route::delete('/delete/{subuserId}', [AdminSubuserController::class, 'destroy'])->name('admin.subusers.destroy');
    });

    Route::resource('resto', RestoAdminController::class)->names('admin.resto');
    Route::resource('hotel', HotelAdminController::class)->names('admin.hotel');

    Route::prefix('/admin/shared-customers')->name('admin.shared_customers.')->group(function () {
        Route::get('/', [AdminSharedCustomerController::class, 'index'])->name('index');
        Route::get('/create', [AdminSharedCustomerController::class, 'create'])->name('create');
        Route::post('/', [AdminSharedCustomerController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminSharedCustomerController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminSharedCustomerController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminSharedCustomerController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/restore', [AdminSharedCustomerController::class, 'restore'])
        ->name('restore');
        Route::post('/{id}/restore', [AdminSharedCustomerController::class, 'restore'])->name('restore');
    });
});

// ======================= RESTO ROUTES =======================
Route::middleware(['auth', 'restoMiddlewareNew'])->prefix('restonew')->name('resto.')->group(function () {
    Route::get('/dashboard', [RestoController::class, 'index'])->name('dashboard');
    Route::get('/okupansi', [OccupancyController::class, 'index'])->name('okupansi');

    Route::resource('order', RestoOrderController::class)->names('orders');

    Route::prefix('uploads')->name('dataorders.')->group(function () {
        Route::get('/', [ExcelUploadController::class, 'index'])->name('index');
        Route::get('/create', [ExcelUploadController::class, 'create'])->name('create');
        Route::post('/store', [ExcelUploadController::class, 'store'])->name('store');
        Route::get('{uploadId}/view', [ExcelUploadController::class, 'show'])->name('show');
        Route::get('{uploadId}/edit', [ExcelUploadController::class, 'edit'])->name('edit');
        Route::post('{uploadId}/update', [ExcelUploadController::class, 'update'])->name('update');
        Route::delete('{uploadId}/delete', [ExcelUploadController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('shared_customers')->name('shared_customers.')->group(function () {
        Route::get('/', [SharedCustomerController::class, 'indexResto'])->name('index_resto');
        Route::get('/create/resto', [SharedCustomerController::class, 'createResto'])->name('create_resto');
        Route::post('/store', [SharedCustomerController::class, 'storeResto'])->name('store');
        Route::get('/{id}/edit/resto', [SharedCustomerController::class, 'editResto'])->name('edit_resto');
        Route::put('/{id}/update/resto', [SharedCustomerController::class, 'updateResto'])->name('update_resto');
        Route::delete('/{id}/delete/resto', [SharedCustomerController::class, 'destroyResto'])->name('destroy_resto');
    });

});

// ======================= HOTEL FRONT OFFICE ROUTES =======================
Route::middleware(['auth', 'frontoffice'])->prefix('frontoffice')->name('hotel.frontoffice.')->group(function () {
    Route::resource('bookings', BookingControllerFo::class)->names('booking');
    Route::resource('migrasi', MigrasiController::class)->names('migrasi');
    Route::post('migrasi/preview', [MigrasiController::class, 'preview'])->name('migrasi.preview');
    Route::post('migrasi/submit', [MigrasiController::class, 'submit'])->name('migrasi.submit');

});

// ======================= HOTEL ROUTES =======================
Route::middleware(['auth', 'hotelMiddlewareNew'])->prefix('hotelnew')->name('hotel.')->group(function () {
    // Dashboard hotel
    Route::get('/dashboard', [HotelController::class, 'index'])->name('dashboard');

    // Statistik okupansi hotel
    Route::get('/okupansi', [OkupansiController::class, 'index'])->name('okupansi');

    // Booking management
    Route::resource('booking', BookingController::class); // Default names: hotel.booking.*

    // Upload Order (Data Booking) - CRUD utama
    Route::resource('databooking', UploadOrderController::class)->names('databooking');

    Route::get('/hotel/databooking/{id}/view-upload-order', [UploadOrderController::class, 'viewUploadOrder'])->name('databooking.viewUploadOrder');
    Route::post('/hotel/databooking/store-import', [UploadOrderController::class, 'storeAndImport'])->name('databooking.storeImport');
    // Upload Order - fitur tambahan
    Route::prefix('databooking')->name('databooking.')->group(function () {
        Route::get('{databooking}/preview', [UploadOrderController::class, 'preview'])->name('preview');
        Route::get('{databooking}/export', [UploadOrderController::class, 'export'])->name('export');
        Route::get('{databooking}/download', [UploadOrderController::class, 'download'])->name('download');
    });


    // Manajemen kamar
    Route::resource('kamar', RoomController::class)->names('rooms');

    Route::prefix('shared_customers')->name('shared_customers.')->group(function () {
        Route::get('/', [SharedCustomerController::class, 'indexHotel'])->name('index_hotel');
        Route::get('/create', [SharedCustomerController::class, 'createHotel'])->name('create_hotel');
        Route::post('shared_customers', [SharedCustomerController::class, 'storeHotel'])->name('store_hotel');
        Route::get('/{id}/edit', [SharedCustomerController::class, 'editHotel'])->name('edit_hotel');
        Route::put('/{id}', [SharedCustomerController::class, 'updateHotel'])->name('update_hotel');
        Route::delete('/{id}', [SharedCustomerController::class, 'destroyHotel'])->name('destroy_hotel');
    });
});


// ======================= HOTEL FINANCE ROUTES =======================
Route::middleware(['auth', 'financehotelMiddleware'])->group(function () {
    Route::resource('/finance', HotelFinanceController::class)->names('finance');
    Route::resource('/migrasi', FinanceMigrasiController::class)->names('finance.migrasi');
});

// ======================= SCM HOTEL ROUTES =======================
Route::middleware(['auth', 'scmhotelMiddleware'])->prefix('scm')->name('scm.')->group(function () {
    Route::resource('transactions', HotelSupplyTransactionController::class)->except(['show', 'edit', 'update'])->names('transactions');
    Route::resource('supplies', HotelSupplyController::class)->except('show')->names('supplies');
    Route::resource('test', testController::class);
});

Route::resource('shared_customers', SharedCustomerController::class);


// ======================= DEFAULT HOME =======================
Route::get('/', fn() => view('welcome'));
