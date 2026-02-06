<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PolisController;
use App\Http\Controllers\OkupasiController;

Route::get('/', function () {
    return view('home');
});

Route::get('register', [RegistrationController::class, 'showForm'])
    ->name('register');

Route::post('register', [RegistrationController::class, 'processForm'])
    ->name('register.process');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.process');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', function () {
        return view('profile.update');
    })->name('profile.update')->middleware('auth');


    Route::get('/dashboard', [PolisController::class, 'getInvoice'])
        ->name('dashboard');

    Route::get('/invoice/{id}', function () {
        return view('invoice.invoice');
    })->name('invoice.invoice')->middleware('auth');


    Route::get('/create-polis', function () {
        return view('polis.create');
    })->name('polis.create')->middleware('auth');

    Route::get('/edit-okupasi', function () {
        return view('okupasi.edit');
    })->name('okupasi.edit')->middleware('auth');


    Route::get('/get-user', [UserController::class, 'getUserData']);
    Route::post('/update-user', [UserController::class, 'updateUserData']);

    Route::post('/create-polis', [PolisController::class, 'createPolis']);
    Route::get('/find-polis/{id}', [PolisController::class, 'findPolis']);
    Route::get('/find-invoice/{id}', [PolisController::class, 'findInvoice']);

    Route::get('/okupasi', [OkupasiController::class, 'getOkupasi']);
    Route::post('/create-okupasi', [OkupasiController::class, 'createOkupasi']);
    Route::post('/update-okupasi/{id}', [OkupasiController::class, 'updateOkupasi']);
    Route::delete('/okupasi/{id}', [OkupasiController::class, 'deleteOkupasi']);
});
