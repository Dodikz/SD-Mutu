<?php

use Illuminate\Support\Facades\Route;


//user
Route::prefix('/')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
});

