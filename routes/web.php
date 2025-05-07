<?php

use App\Http\Controllers\ClientManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->Middleware('maintenance');


Route::resource('/client', ClientManagementController::class )->Middleware('maintenance');
Route::post('/client/store', [ClientManagementController::class, 'store'])->name('client.store');
Route::put('/update-client/{id}', [ClientManagementController::class, 'update'])->name('client.update');
Route::delete('/delete-client/{id}', [ClientManagementController::class, 'destroy'])->name('client.destroy');
Route::get('/check-client-id/{clientId}', [ClientManagementController::class, 'checkClientId']);
Route::get('/client/check-id', [ClientManagementController::class, 'checkClientId'])->name('client.checkId');
Route::put('/client/update/{id}', [ClientManagementController::class, 'update'])->name('client.update');

Route::get('/maintenance',[ClientManagementController::class,"maintenance"]);
// Add this route to your web.php file
Route::get('/get-next-client-id', [ClientManagementController::class, 'getNextClientId']);