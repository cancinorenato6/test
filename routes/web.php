<?php

use App\Http\Controllers\ClientManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/client', ClientManagementController::class );
Route::post('/client/store', [ClientManagementController::class, 'store'])->name('client.store');