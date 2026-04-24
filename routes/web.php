<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientoController;

Route::get('/importar', function () {
    return view('poa.importar');
})->name('importar.index');

Route::post('/importar', [MovimientoController::class, 'import'])->name('importar.store');

use App\Http\Controllers\EstadoResultadosController;

Route::get('/estado-resultados', [EstadoResultadosController::class, 'index'])->name('estado-resultados.index');
Route::get('/estado-resultados/export', [EstadoResultadosController::class, 'export'])->name('estado-resultados.export');
Route::post('/estado-resultados/import', [EstadoResultadosController::class, 'import'])->name('estado-resultados.import');
Route::post('/estado-resultados/store', [EstadoResultadosController::class, 'store'])->name('estado-resultados.store');

use App\Http\Controllers\PoaController;

Route::get('/poa', [PoaController::class, 'index'])->name('poa.index');
Route::post('/poa/sync', [PoaController::class, 'sync'])->name('poa.sync');

Route::get('/', function () {
    return view('welcome');
});
