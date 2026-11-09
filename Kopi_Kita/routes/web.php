
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// LOGIN
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

});

// SEMUA PENGGUNA YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // DASHBOARD ADMIN DAN KASIR
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // =====================================
    // KHUSUS ADMIN
    // =====================================

    Route::middleware('role:admin')->group(function () {

        // Manajemen menu
        Route::resource('menus', MenuController::class);

        // Laporan penjualan
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        // PDF laporan
        Route::get('/reports/{id}/pdf', [ReportController::class, 'pdf'])
            ->name('reports.pdf');

    });


    // =====================================
    // KHUSUS KASIR
    // =====================================

    Route::middleware('role:kasir')->group(function () {

        // Halaman transaksi
        Route::get('/pos', [TransactionController::class, 'index'])
            ->name('pos.index');

        // Proses pembayaran
        Route::post('/transactions', [TransactionController::class, 'store'])
            ->name('transactions.store');

    });


    // =====================================
    // STRUK TRANSAKSI
    // BISA DIAKSES ADMIN DAN KASIR
    // =====================================

    Route::get('/reports/{id}', [ReportController::class, 'show'])
        ->name('reports.show');

});
