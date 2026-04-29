<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\EstadoResultadosController;
use App\Http\Controllers\PoaController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/importaciones', [ImportController::class, 'index'])->name('importaciones.index');
Route::post('/importaciones/er', [ImportController::class, 'importER'])->name('importaciones.er');
Route::post('/importaciones/ventas', [ImportController::class, 'importVentas'])->name('importaciones.ventas');
Route::post('/importaciones/pdf-realizado', [ImportController::class, 'importPDFRealizado'])->name('importaciones.pdf-realizado');

Route::get('/estado-resultados', [EstadoResultadosController::class, 'index'])->name('estado-resultados.index');
Route::get('/estado-resultados/export', [EstadoResultadosController::class, 'export'])->name('estado-resultados.export');
Route::post('/estado-resultados/store', [EstadoResultadosController::class, 'store'])->name('estado-resultados.store');
Route::post('/estado-resultados/import-pdf', [EstadoResultadosController::class, 'importPDF'])->name('estado-resultados.import-pdf');

Route::get('/poa', [PoaController::class, 'index'])->name('poa.index');
