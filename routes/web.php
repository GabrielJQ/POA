<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\EstadoResultadosController;
use App\Http\Controllers\PoaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;

// Auth (guest)
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Auth (authenticated)
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('can:view-dashboard');

    Route::get('/importaciones', [ImportController::class, 'index'])->name('importaciones.index');
    Route::post('/importaciones/er', [ImportController::class, 'importER'])->name('importaciones.er');
    Route::post('/importaciones/ventas', [ImportController::class, 'importVentas'])->name('importaciones.ventas');
    Route::post('/importaciones/pdf-realizado', [ImportController::class, 'importPDFRealizado'])->name('importaciones.pdf-realizado');
    Route::post('/importaciones/surtimiento', [ImportController::class, 'importSurtimiento'])->name('importaciones.surtimiento');
    Route::post('/importaciones/mermas', [ImportController::class, 'importMermas'])->name('importaciones.mermas');
    Route::post('/importaciones/mermas-comprometido', [ImportController::class, 'importMermasComprometido'])->name('importaciones.mermas-comprometido');
    Route::post('/importaciones/apertura-tiendas', [ImportController::class, 'importAperturaTiendas'])->name('importaciones.apertura-tiendas');

    Route::get('/estado-resultados', [EstadoResultadosController::class, 'index'])->name('estado-resultados.index');
    Route::get('/estado-resultados/export', [EstadoResultadosController::class, 'export'])->name('estado-resultados.export');
    Route::post('/estado-resultados/store', [EstadoResultadosController::class, 'store'])->name('estado-resultados.store');
    Route::post('/estado-resultados/import-pdf', [EstadoResultadosController::class, 'importPDF'])->name('estado-resultados.import-pdf');

    Route::get('/poa', [PoaController::class, 'index'])->name('poa.index');
    Route::get('/poa/export', [PoaController::class, 'export'])->name('poa.export');
    Route::post('/poa/nota', [PoaController::class, 'saveNota'])->name('poa.nota.save');
    Route::get('/poa/reales', [PoaController::class, 'getReales'])->name('poa.reales');
    Route::post('/poa/reales/guardar', [PoaController::class, 'guardarReales'])->name('poa.reales.guardar');

    // Admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });
});
