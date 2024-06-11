<?php

    use App\Http\Controllers\AccountController;
    use App\Http\Controllers\AccountImport;
    use App\Http\Controllers\PiggybankController;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('dashboard');
    })->name('home');

    Route::resource('accounts', AccountController::class)->names([
        'index' => 'accounts'
    ]);

    Route::resource('piggybanks', PiggybankController::class)->names([
        'index' => 'piggybanks'
    ]);

    Route::get('import',function(){
       return view('import');
    })->name('import');

    Route::post('createFromFile',[AccountImport::class,'CreateFromImport'])->name('createFromFile');

