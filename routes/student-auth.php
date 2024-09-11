<?php

use App\Http\Controllers\Student\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Student\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('student')->middleware('guest:student')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('student.login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::prefix('student')->middleware('auth:student')->group(function () {

    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('student.logout');
});
