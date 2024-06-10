<?php

    use App\Http\Controllers\AccountController;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('dashboard');
    })->name('home');

    Route::resource('accounts', AccountController::class)->names([
        'index' => 'accounts'
    ]);

