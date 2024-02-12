<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::get('/links', [LinksController::class, 'index'])->name('links.index');
    Route::post('/links', [LinksController::class, 'store'])->name('links.store');
    Route::delete('/links/{link}', [LinksController::class, 'destroy'])->name('links.destroy');
});

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
    Route::get('register', [RegistrationController::class, 'create'])->name('register');
    Route::post('register', [RegistrationController::class, 'store']);
});

Route::get('/{link}', [LinksController::class, 'out'])->name('links.out');
