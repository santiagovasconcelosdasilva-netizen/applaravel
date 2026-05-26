<?php

use App\Http\Controllers\ContactoController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/contactos');
Route::view('/produtos', 'home')->name('home');
Route::resource('contactos', ContactoController::class);
