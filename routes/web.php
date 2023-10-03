<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Member\Auth\AuthController as MemberAuthController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::post('/register', [RegisterController::class, 'store']);
Route::get('/payment-registration/{document}/{email}', [RegisterController::class, 'paymentRegister']);


// Route::get('/sheets', [RegisterController::class, 'sheets']);


// Route::middleware('guest')->get('/login', function () {
//     return Inertia::render('Auth/Login');
// })->name('login');
Route::post('/sign-in', [AuthController::class, 'signIn']);
Route::delete('/sign-out', [AuthController::class, 'signOut']);


Route::middleware('auth')->get('/admin', [AdminController::class, 'index']);
Route::middleware('auth')->post('/admin/validate-pre-registration', [AdminController::class, 'validatePreRegistration']);
Route::middleware('auth')->get('/admin/members-aprovet', [AdminController::class, 'memberAprovet']);






Route::name('member.')->prefix('')->group(function () {

    Route::middleware('auth:member')->get('/m',  [MemberController::class, 'index'])->name('home');

    Route::get('/login',  [MemberAuthController::class, 'index'])->name('login')->middleware('guest:member');
    // Route::get('/register',  [MemberAuthController::class, 'register'])->name('register')->middleware('guest:member');

    Route::get('/create-password/{token}',  [MemberAuthController::class, 'createPassword'])->name('create.password');
    
    Route::get('/verification-email/{email}',  [MemberAuthController::class, 'verificationEmail'])->name('verification.email');

    

    Route::post('/member/sign-in', [MemberAuthController::class, 'signIn']);
    Route::post('/member/save-password', [MemberAuthController::class, 'savePassword']);
    Route::delete('/member/sign-out', [MemberAuthController::class, 'signOut']);
});


Route::name('admin.')->prefix('admin')->group(function () {

    Route::middleware('auth')->get('/',  [AdminController::class, 'index'])->name('home');
    Route::middleware('auth')->get('/inscribed',  [AdminController::class, 'inscribed'])->name('inscribed');
    

    Route::get('/login',  [AuthController::class, 'index'])->name('login')->middleware('guest');

    Route::middleware('auth')->post('/validate-payment', [AdminController::class, 'validatePayment']);
    Route::middleware('auth')->post('/send-email', [AdminController::class, 'sendEmail']);

    Route::middleware('auth')->get('/export-inscribed', [AdminController::class, 'exportInscribed']);

    Route::post('/sign-in', [AuthController::class, 'signIn']);
    Route::delete('/sign-out', [AuthController::class, 'signOut']);
});

//registrado - correo validado - (voucher validado - inscrito) - rechazado 