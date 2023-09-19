<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::post('/register', [RegisterController::class, 'store']);

Route::get('/sheets', [RegisterController::class, 'sheets']);


Route::middleware('guest')->get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');
Route::post('/sign-in', [AuthController::class, 'signIn']);
Route::delete('/sign-out', [AuthController::class, 'signOut']);


Route::middleware('auth')->get('/admin', [AdminController::class, 'index']);
Route::middleware('auth')->post('/admin/update-menber-sheet', [AdminController::class, 'updateCell']);

