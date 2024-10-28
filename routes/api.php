<?php

use App\Http\Controllers\Api\TicketApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VisitaApiController;


Route::get('tickets/{phone}',[TicketApiController::class,'index'])
        ->name('api.tickets.index');
Route::get('tickets-update/{phone}',[TicketApiController::class,'update'])
        ->name('api.tickets.update');

Route::put('visitas/{id}', [VisitaApiController::class, 'update'])->name('api.visitas.update');
Route::get('/visitas',[VisitaApiController::class,'index'])->name('api.visitas.index');
Route::post('/visitas',[VisitaApiController::class, 'store'])->name('api.visitas.store');
Route::get('/visitas-end/{phone}',[VisitaApiController::class,'visitasEnd'])->name('api.visitas.end');


Route::get('/user', function (Request $request) {
        return $request->user();
})->middleware('auth:sanctum');
