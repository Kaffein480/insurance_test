<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OkupasiController;
use App\Http\Controllers\PolisController;



// Route::post('/create-polis', [PolisController::class, 'createPolis']);
Route::get('/find-polis/{id}', [PolisController::class, 'findPolis']);


Route::get('/okupasi', [OkupasiController::class, 'getOkupasi']);
Route::post('/okupasi', [OkupasiController::class, 'createOkupasi']);
Route::put('/okupasi/{id}', [OkupasiController::class, 'updateOkupasi']);
Route::delete('/okupasi/{id}', [OkupasiController::class, 'deleteOkupasi']);



