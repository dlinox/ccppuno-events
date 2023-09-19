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
Route::get('/payment-registration/{document}/{email}', [RegisterController::class, 'paymentRegister']);


// Route::get('/sheets', [RegisterController::class, 'sheets']);


Route::middleware('guest')->get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');
Route::post('/sign-in', [AuthController::class, 'signIn']);
Route::delete('/sign-out', [AuthController::class, 'signOut']);




Route::middleware('auth')->get('/admin', [AdminController::class, 'index']);
Route::middleware('auth')->post('/admin/validate-pre-registration', [AdminController::class, 'validatePreRegistration']);
Route::middleware('auth')->get('/admin/members-aprovet', [AdminController::class, 'memberAprovet']);

Route::middleware('auth')->post('/admin/validate-payment', [AdminController::class, 'validatePayment']);
