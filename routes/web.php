<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\UserController;
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

// Public Route - Form Tamu
Route::get('/', [VisitorController::class, 'publicForm'])->name('visitor.form');
Route::post('/visitor/store', [VisitorController::class, 'publicStore'])->name('visitor.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // BTD Paljaya Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
    Route::resource('visitors', VisitorController::class);
    Route::post('/visitors/{id}/toggle-status', [VisitorController::class, 'toggleStatus'])->name('visitors.toggle-status');
    Route::get('/visitors/export', [VisitorController::class, 'export'])->name('visitors.export');
    Route::resource('users', UserController::class);
});

require __DIR__ . '/auth.php';
