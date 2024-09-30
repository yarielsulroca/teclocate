<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\VisitaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/visit-init/{phone}', [TicketController::class, 'index'])->name('api.visit.init.index');
Route::get('/visit-end/{phone}', [TicketController::class, 'update'])->name('api.visit.end.update');
Route::put('visitas/update/{id}/{latitude}/{longitude}', [VisitaController::class, 'update'])->name('visitas.update');
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
    ]);
});

Route::post('/import-clientes', [ClienteController::class, 'import'])
        ->name('clientes.import');
Route::get('/export-clientes', [ClienteController::class, 'export'])
        ->name('clientes.export');


require __DIR__.'/auth.php';


