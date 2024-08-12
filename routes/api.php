<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/customer')->group(function () {
    Route::get('/getAddresses/{id}', [Controller::class, 'getAddresses'])->name('customer.getAddresses');
    Route::post('/addOrder', [Controller::class, 'addOrder'])->name('customer.addOrder');
});

Route::get('/order/{id}', [Controller::class, 'downloadXML'])->name('order.downloadXML');
Route::get('/orderPDF/{id}', [Controller::class, 'generatePDF'])->name('order.generatePDF');

Route::delete('/deleteOrder/{id}', [Controller::class, 'softDelete'])->name('order.softDelete');