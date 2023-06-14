<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MKategoriController;
use App\Http\Controllers\MChartOfAccountController;
use App\Http\Controllers\TbTransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return view('layout.template');
});

Route::resource('kategori', MKategoriController::class);
Route::resource('coa', MChartOfAccountController::class);
Route::resource('transaksi', TbTransaksiController::class);