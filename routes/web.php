<?php

use App\Http\Controllers\Admin\AdminSharedCustomerController;
use App\Http\Controllers\Admin\AdminSubuserController;
use App\Http\Controllers\admin\CombinedReportController;
use App\Http\Controllers\Admin\HotelRestoLinkController;
use App\Http\Controllers\Admin\RestoAdminController;
use App\Http\Controllers\Hotel\Finance\FinanceMigrasiController;
use App\Http\Controllers\Hotel\Finance\HotelFinanceController;
use App\Http\Controllers\hotel\FinanceController;
use App\Http\Controllers\hotel\frontoffice\SharedCustomerFOController;
use App\Http\Controllers\Hotel\HotelSCMController;
use App\Http\Controllers\Hotel\SCM\HotelSupplyTransactionController;
use App\Http\Controllers\Hotel\SCM\RoomSCMController;
use App\Http\Controllers\Hotel\SCM\testController;
use App\Http\Controllers\hotel\SharedCustomerHotelController;
use App\Http\Controllers\Resto\Cashier\MigrasiOrderController;
use App\Http\Controllers\Resto\Finance\RestoFinanceImportController;
use App\Http\Controllers\Resto\RestoFinanceController;
use App\Http\Controllers\resto\RestoSupplyRestonewController;
use App\Http\Controllers\Resto\RestoTableController;
use App\Http\Controllers\Resto\Scm\RestoSupplyController;
use App\Http\Controllers\Resto\Scm\RestoSupplyTransactionController;
use App\Http\Controllers\resto\SharedCustomerRestoController;
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
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\Resto\Cashier\CashierOrderController;
use App\Http\Controllers\Resto\Cashier\CashierCustomerController;
use App\Http\Controllers\Resto\Finance\FinanceTransactionController;
use App\Http\Controllers\Resto\Scm\ScmTransactionController;
use App\Http\Controllers\Resto\Scm\ScmTableController;
use App\Http\Controllers\Hotel\FrontOffice\FOBookingImportController;


use Illuminate\Support\Facades\Artisan;

Route::get('/run-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created!';
});


Route::get('/run-sync-income', function () {
    Artisan::call('sync:income-finances');
    return 'Command sync:income-finances executed!';
});

Route::get('/run-sync-combined', function () {
    Artisan::call('sync:combined-reports');
    return 'Command sync:combined-reports executed!';
});

Route::get('/run-schedule', function () {
    Artisan::call('schedule:run');
    return 'Schedule run executed!';
});

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
        Route::post('/{id}/restore', [UserAdminController::class, 'restore'])->name('admin.user.restore');
    });

    // Subuser Management
    Route::prefix('/admin/subusers')->group(function () {
        Route::get('/{id}', [AdminSubuserController::class, 'index'])->name('admin.user.subuser.index');
        Route::get('/{id}/create', [AdminSubuserController::class, 'create'])->name('admin.subusers.create');
        Route::post('/{id}', [AdminSubuserController::class, 'store'])->name('admin.subusers.store');
        Route::get('/edit/{subuserId}', [AdminSubuserController::class, 'edit'])->name('admin.subusers.edit');
        Route::put('/update/{subuserId}', [AdminSubuserController::class, 'update'])->name('admin.subusers.update');
        Route::delete('/delete/{subuserId}', [AdminSubuserController::class, 'destroy'])->name('admin.subusers.destroy');
        Route::post('/restore/{subuserId}', [AdminSubuserController::class, 'restore'])->name('admin.subusers.restore');
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
        Route::get('/{id}/restore', [AdminSharedCustomerController::class, 'restore']);
        Route::post('/{id}/restore', [AdminSharedCustomerController::class, 'restore'])->name('restore');
    });

    Route::resource('hotel-resto-links', HotelRestoLinkController::class);

    Route::get('/combined-reports', [CombinedReportController::class, 'index'])->name('combined-reports.index');


});

// ======================= RESTO ROUTES =======================
Route::middleware(['auth', 'restoMiddlewareNew'])->prefix('restonew')->name('resto.')->group(function () {
    Route::get('/dashboard', [RestoController::class, 'index'])->name('dashboard');
    Route::get('/okupansi', [OccupancyController::class, 'index'])->name('okupansi');

    Route::resource('orders', controller: RestoOrderController::class)->names('orders');
    Route::resource('finances', RestoFinanceController::class)->names('finances');
    Route::resource('tables', RestoTableController::class);

    Route::post('/orders/{id}/approve', [RestoOrderController::class, 'approve'])->name('orders.approve');
    Route::post('/orders/{id}/reject', [RestoOrderController::class, 'reject'])->name('orders.reject');
    Route::post('/finances/{id}/approve', [RestoFinanceController::class, 'approve'])->name('finances.approve');
    Route::post('/finances/{id}/reject', [RestoFinanceController::class, 'reject'])->name('finances.reject');
    Route::post('/finances/bulk-approve', [RestoFinanceController::class, 'bulkApprove'])->name('finances.bulk-approve');
    Route::post('/finances/bulk-reject', [RestoFinanceController::class, 'bulkReject'])->name('finances.bulk-reject');

    Route::post('bulk-approve', [RestoOrderController::class, 'bulkApprove'])->name('orders.bulkApprove');
    Route::post('bulk-reject', [RestoOrderController::class, 'bulkReject'])->name('orders.bulkReject');

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
        Route::get('/', [SharedCustomerRestoController::class, 'indexResto'])->name('index_resto');
        Route::get('/create/resto', [SharedCustomerRestoController::class, 'createResto'])->name('create_resto');
        Route::post('/store', [SharedCustomerRestoController::class, 'storeResto'])->name('store');
        Route::get('/{id}/edit/resto', [SharedCustomerRestoController::class, 'editResto'])->name('edit_resto');
        Route::put('/{id}/update/resto', [SharedCustomerRestoController::class, 'updateResto'])->name('update_resto');
        Route::delete('/{id}/delete/resto', [SharedCustomerRestoController::class, 'destroyResto'])->name('destroy_resto');
    });

    Route::resource('supplies', RestoSupplyRestonewController::class);

});

// ======================= CASHIER RESTO ROUTES =======================
Route::middleware(['auth', 'cashierresto'])->prefix('cashierresto')->name('cashierresto.')->group(function () {
    Route::resource('orders', CashierOrderController::class)->except(['show']);
    Route::resource('customers', CashierCustomerController::class);
    Route::get('/orders/import', [MigrasiOrderController::class, 'showForm'])->name('resto.orders.import.form');
    Route::post('/orders/import', [MigrasiOrderController::class, 'import'])->name('resto.orders.import');
    Route::get('/orders/history', [MigrasiOrderController::class, 'history'])->name('resto.orders.history');
    Route::delete('/orders/history/{id}', [MigrasiOrderController::class, 'destroy'])->name('resto.orders.destroy');

});

// ======================= FINACNE RESTO ROUTES =======================
Route::middleware(['auth', 'financeresto'])->prefix('financeresto')->name('financeresto.')->group(function () {
    Route::resource('finances', FinanceTransactionController::class);
    Route::get('/import/create', [RestoFinanceImportController::class, 'showForm'])->name('import.form'); // upload form
    Route::post('/import', [RestoFinanceImportController::class, 'import'])->name('import'); // process
    Route::get('/import/history', [RestoFinanceImportController::class, 'history'])->name('import.history'); // index
    Route::delete('/import/{id}', [RestoFinanceImportController::class, 'destroy'])->name('import.destroy');
});

// ======================= SCM RESTO ROUTES =======================
Route::middleware(['auth', 'scmresto'])->prefix('scmresto')->name('scmresto.')->group(function () {
    Route::resource('supplies', RestoSupplyController::class);
    Route::resource('transactions', RestoSupplyTransactionController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('tables', ScmTableController::class);
});

// ======================= HOTEL ROUTES =======================
Route::middleware(['auth', 'hotelMiddlewareNew'])->prefix('hotelnew')->name('hotel.')->group(function () {
    // Dashboard hotel
    Route::get('/dashboard', [HotelController::class, 'index'])->name('dashboard');

    // Statistik okupansi hotel
    Route::get('/okupansi', [OkupansiController::class, 'index'])->name('okupansi');

    // Booking management
    Route::resource('booking', BookingController::class); // Default names: hotel.booking.*
    Route::post('booking/{id}/approve', [BookingController::class, 'approve'])->name('booking.approve');
    Route::post('booking/{id}/reject', [BookingController::class, 'reject'])->name('booking.reject');


    // Upload Order (Data Booking) - CRUD utama
    Route::resource('databooking', UploadOrderController::class)->names('databooking');

    Route::get('/hotel/databooking/{id}/view-upload-order', [UploadOrderController::class, 'viewUploadOrder'])->name('databooking.viewUploadOrder');
    Route::post('/hotel/databooking/store-import', [UploadOrderController::class, 'storeAndImport'])->name('databooking.storeImport');
    Route::prefix('databooking')->name('databooking.')->group(function () {
        Route::get('{databooking}/preview', [UploadOrderController::class, 'preview'])->name('preview');
        Route::get('{databooking}/export', [UploadOrderController::class, 'export'])->name('export');
        Route::get('{databooking}/download', [UploadOrderController::class, 'download'])->name('download');
    });


    // Manajemen kamar
    Route::resource('room', RoomController::class)->names('rooms');

    Route::prefix('shared_customers')->name('shared_customers.')->group(function () {
        Route::get('/', [SharedCustomerHotelController::class, 'indexHotel'])->name('index');
        Route::get('/create', [SharedCustomerHotelController::class, 'createHotel'])->name('create');
        Route::post('shared_customers', [SharedCustomerHotelController::class, 'storeHotel'])->name('store');
        Route::get('/{id}/edit', [SharedCustomerHotelController::class, 'editHotel'])->name('edit');
        Route::put('/{id}', [SharedCustomerHotelController::class, 'updateHotel'])->name('update');
        Route::delete('/{id}', [SharedCustomerHotelController::class, 'destroyHotel'])->name('destroy');
    });

    Route::resource('/finance', FinanceController::class)->names('finance');
    Route::post('finance/{id}/approve', [FinanceController::class, 'approve'])->name('finance.approve');
    Route::post('finance/{id}/reject', [FinanceController::class, 'reject'])->name('finance.reject');
    Route::post('/finance/bulk-action', [FinanceController::class, 'bulkAction'])->name('finance.bulk-action');
    Route::post('/finance/bulk-reject', [FinanceController::class, 'bulkReject'])->name('finance.bulk-reject');

    Route::resource('scm', HotelSCMController::class)->names('scm');
    Route::post('/hotel/booking/bulk-approve', [BookingController::class, 'bulkApprove'])->name('booking.bulkApprove');
    Route::post('/hotel/booking/bulk-reject', [BookingController::class, 'bulkReject'])->name('booking.bulkReject');
    Route::post('/finance/bulk-action', [FinanceController::class, 'bulkAction'])->name('finance.bulk-action');
    Route::post('/finance/bulk-reject', [FinanceController::class, 'bulkReject'])->name('finance.bulk-reject');

});

// ======================= HOTEL FRONT OFFICE ROUTES =======================
Route::middleware(['auth', 'frontoffice'])->prefix('frontoffice')->name('hotel.frontoffice.')->group(function () {
    Route::resource('bookings', BookingControllerFo::class)->names('booking');
    Route::resource('migrasi', MigrasiController::class)->names('migrasi');
    Route::post('migrasi/preview', [MigrasiController::class, 'preview'])->name('migrasi.preview');
    Route::post('migrasi/submit', [MigrasiController::class, 'submit'])->name('migrasi.submit');

    Route::prefix('shared_customers')->name('shared_customers.')->group(function () {
        Route::get('/', [SharedCustomerFOController::class, 'indexHotel'])->name('index_hotel');
        Route::get('/create', [SharedCustomerFOController::class, 'createHotel'])->name('create_hotel');
        Route::post('shared_customers', [SharedCustomerFOController::class, 'storeHotel'])->name('store_hotel');
        Route::get('/{id}/edit', [SharedCustomerFOController::class, 'editHotel'])->name('edit_hotel');
        Route::put('/{id}', [SharedCustomerFOController::class, 'updateHotel'])->name('update_hotel');
        Route::delete('/{id}', [SharedCustomerFOController::class, 'destroyHotel'])->name('destroy_hotel');
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

    Route::resource('room', RoomSCMController::class)->names('rooms');

});

// Route::resource('shared_customers', SharedCustomerController::class);






Schedule::command('sync:income-finances')->dailyAt('23:55');

// ======================= DEFAULT HOME =======================
Route::get('/', fn() => view('welcome'));
