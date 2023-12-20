<?php

use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Route;

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
    return redirect('/admin/');
});

Route::get('/print-sales-report', [PrintController::class, 'printSalesReport'])->name('printSalesReport');
Route::get('/print-products-report', [PrintController::class, 'printProductsReport'])->name('printProductsReport');
