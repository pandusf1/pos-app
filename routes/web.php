<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ReturPenjualanController;
use App\Http\Controllers\ReturPembelianController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));


Route::get('/login', [AuthController::class, 'login'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'loginProcess']);

Route::get('/register', [RegisterController::class, 'showRegisterForm'])
    ->name('register')
    ->middleware('guest');

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


/*
|--------------------------------------------------------------------------
| SOCIAL LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback']);


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| TRANSAKSI (PENJUALAN & PEMBELIAN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {

    /* ===================== PENJUALAN ===================== */
    Route::prefix('jual')->name('jual.')->group(function () {
        Route::get('/', [PenjualanController::class, 'index'])->name('index');
        Route::post('/', [PenjualanController::class, 'store'])->name('store');
        Route::get('/{no_jual}', [PenjualanController::class, 'show'])->name('show');

        // 🔥 STRUK OTOMATIS (nota / bukti memorial)
        Route::get('/{no_jual}/cetak', [PenjualanController::class, 'struk'])
            ->name('cetak');
    });
 
// RETUR PENJUALAN - KASIR
Route::middleware(['auth','role:kasir'])->group(function () {
    Route::prefix('retur-penjualan')->name('retur.penjualan.')->group(function () {
        Route::get('/', [ReturPenjualanController::class, 'index'])->name('index');
        Route::post('/simpan', [ReturPenjualanController::class, 'store'])->name('store');
    });
});

Route::middleware(['auth'])->group(function () {
Route::get('/laporan/retur-penjualan', 
    [ReturPenjualanController::class, 'laporan']
)->name('laporan.retur.penjualan');
});

// RETUR PEMBELIAN - ADMIN
Route::middleware(['auth','role:admin'])->group(function () {
    Route::prefix('retur-pembelian')->name('retur.pembelian.')->group(function () {
        Route::get('/', [ReturPembelianController::class, 'index'])->name('index');
        Route::post('/simpan', [ReturPembelianController::class, 'store'])->name('store');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/laporan/retur-pembelian',
        [ReturPembelianController::class, 'laporan']
    )->name('laporan.retur.pembelian');
});
    
    /* ===================== PEMBELIAN ===================== */
    Route::prefix('beli')->name('beli.')->group(function () {
        Route::get('/', [PembelianController::class, 'index'])->name('index');
        Route::post('/', [PembelianController::class, 'store'])->name('store');
        Route::get('/{no_beli}', [PembelianController::class, 'show'])->name('show');

        // 🔥 STRUK PEMBELIAN / MEMORIAL
        Route::get('/{no_beli}/cetak', [PembelianController::class, 'struk'])
            ->name('cetak');
    });
});

/*
|--------------------------------------------------------------------------
| MASTER DATA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('barang', BarangController::class);
    Route::resource('konsumen', KonsumenController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('users', UserManagementController::class);
});

/*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::prefix('laporan/penjualan')->name('laporan.penjualan.')->group(function () {
        Route::get('/', [LaporanPenjualanController::class, 'index'])->name('index');
        Route::get('/pdf', [LaporanPenjualanController::class, 'exportPDF'])->name('pdf');
        Route::get('/excel', [LaporanPenjualanController::class, 'exportExcel'])->name('excel');
    });

    Route::prefix('laporan/pembelian')->name('laporan.pembelian.')->group(function () {
        Route::get('/', [LaporanPembelianController::class, 'index'])->name('index');
        Route::get('/pdf', [LaporanPembelianController::class, 'exportPDF'])->name('pdf');
        Route::get('/excel', [LaporanPembelianController::class, 'exportExcel'])->name('excel');
    });

    Route::prefix('laporan/barang')->name('laporan.barang.')->group(function () {
        Route::get('/', [BarangController::class, 'laporanIndex'])->name('index');
        Route::get('/pdf', [BarangController::class, 'laporanPdf'])->name('pdf');
        Route::get('/excel', [BarangController::class, 'laporanExcel'])->name('excel');
    });

    Route::prefix('laporan/konsumen')->name('laporan.konsumen.')->group(function () {
        Route::get('/', [KonsumenController::class, 'laporanIndex'])->name('index');
        Route::get('/pdf', [KonsumenController::class, 'laporanPDF'])->name('pdf');
        Route::get('/excel', [KonsumenController::class, 'laporanExcel'])->name('excel');
    });

    Route::prefix('laporan/supplier')->name('laporan.supplier.')->group(function () {
        Route::get('/', [SupplierController::class, 'laporanIndex'])->name('index');
        Route::get('/pdf', [SupplierController::class, 'laporanPDF'])->name('pdf');
        Route::get('/excel', [SupplierController::class, 'laporanExcel'])->name('excel');
    });

    Route::get('/laporan/retur-pembelian', [ReturPembelianController::class, 'laporan'])
    ->name('laporan.retur.pembelian');
    
});