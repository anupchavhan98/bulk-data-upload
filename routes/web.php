<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserDataController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [UserDataController::class, 'index']);
Route::post('/users/upload', [UserDataController::class, 'upload']);
