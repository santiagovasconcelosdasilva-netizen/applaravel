<?php

use App\Http\Controllers\ContactoController;
use App\Http\Controllers\LocalidadeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/contactos');

Route::view('/produtos', 'home')->name('home');

Route::resource('contactos', ContactoController::class);
Route::get('grupos', [ContactoController::class, 'groups'])->name('grupos.index');
Route::resource('localidades', LocalidadeController::class);