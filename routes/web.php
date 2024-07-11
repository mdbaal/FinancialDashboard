<?php

    use App\Http\Controllers\AccountController;
    use App\Http\Controllers\AccountImport;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\PiggybankController;
    use App\Http\Controllers\TransactionController;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('dashboard');
    })->name('home');

    Route::resource('accounts', AccountController::class);

    Route::resource("categories", CategoryController::class);

    Route::resource('accounts.transactions', TransactionController::class);

    Route::resource('piggybanks', PiggybankController::class);

    Route::get('import',function(){
       return view('import');
    })->name('import');

    Route::post('createFromFile',[AccountImport::class,'CreateFromImport'])->name('createFromFile');


