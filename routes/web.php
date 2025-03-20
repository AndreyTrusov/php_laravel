<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('form');
});



//
//Route::post('/submit', [TestController::class, 'submitForm'])->name('submit.form');



