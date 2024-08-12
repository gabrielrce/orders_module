<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\CustomerShippingAddresses;
use App\Models\Products;
use App\Models\OrderProducts;
use App\Models\Orders;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $customers = Customers::all();
    $customerShippingAddresses = CustomerShippingAddresses::where('customer_id', 1)->get();
    $products = Products::all();
    return view('addOrder', ['customers' => $customers, 'products' => $products, 'customerShippingAddresses' => $customerShippingAddresses]);
})->name('addOrder');
Route::get('/orders', function () {
    $orderProducts = Orders::with(['customer', 'shippingAddress'])->where('active', 1)->get();
    return view('viewOrders', ['orderProducts' => $orderProducts]);
})->name('orders');