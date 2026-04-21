<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::redirect('login', '/main/login');
Route::redirect('register', '/main/register');
Route::redirect('forgot-password', '/main/forgot-password');
Route::redirect('reset-password/{token}', '/main/reset-password/{token}');
Route::redirect('email/verify', '/main/email/verify');
Route::redirect('user/confirm-password', '/main/user/confirm-password');
Route::redirect('two-factor-challenge', '/main/two-factor-challenge');

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::group(['prefix' => '{company?}'], function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    });
});

require __DIR__.'/settings.php';
