<?php

use App\Http\Controllers\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

// Apply middleware to restrict access to the 'home' route to authenticated users only
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/pelanggan', [Penjualan::class, 'pelanggan'])->name('pelanggan');
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::post('/addpelanggan', [Penjualan::class, 'addpelanggan'])->name('addpelanggan');
    Route::post('/editpelanggan/{id}', [Penjualan::class, 'editpelanggan'])->name('editpelanggan');
    Route::get('/deletepelanggan/{id}', [Penjualan::class, 'deletepelanggan'])->name('deletepelanggan');

    Route::get('/barang', [Penjualan::class, 'barang'])->name('barang');
    Route::post('/addbarang', [Penjualan::class, 'addbarang'])->name('addbarang');
    Route::post('/editbarang/{id}', [Penjualan::class, 'editbarang'])->name('editbarang');
    Route::get('/deletebarang/{id}', [Penjualan::class, 'deletebarang'])->name('deletebarang');

    Route::get('/suppliers', [Penjualan::class, 'supplier'])->name('supplier');   
    Route::post('/addsupplier', [Penjualan::class, 'addsupplier'])->name('addsupplier');
    Route::post('/editsupplier/{supplier_id}', [Penjualan::class, 'editsupplier'])->name('editsupplier');
    Route::get('/deletesupplier/{supplier_id}', [Penjualan::class, 'deletesupplier'])->name('deletesupplier');
});
