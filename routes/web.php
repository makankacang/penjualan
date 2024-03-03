<?php

use App\Http\Controllers\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;


Auth::routes();

// Apply middleware to restrict access to the 'home' route to authenticated users only
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/homepel', [HomeController::class, 'indexpel'])->name('homepel');
    Route::get('/sukses', [Penjualan::class, 'sukses'])->name('sukses');
    Route::get('/getCartCount', [Penjualan::class, 'getCartCount']);
    Route::get('/shop', [Penjualan::class, 'shop'])->name('shop');
    Route::get('/detailbarang/{id}', [Penjualan::class, 'detail'])->name('detail');
    Route::get('/keranjang', [Penjualan::class, 'showCart'])->name('cart');
    Route::get('/pesanan-saya', [Penjualan::class, 'showpesanan'])->name('pesanan');
    Route::delete('/cancelorder/{id}', [Penjualan::class, 'cancelOrder']);
    Route::post('/confirmorder', [Penjualan::class, 'confirmOrder'])->name('confirmorder');
    Route::post('/unconfirmorder', [Penjualan::class, 'unconfirmOrder'])->name('unconfirmorder');
    Route::post('/completeorder', [Penjualan::class, 'completeOrder'])->name('completeorder');
    Route::post('/add-to-cart/{barang}', [Penjualan::class, 'addToCart'])->name('add-to-cart');
    Route::delete('/deletecart/{id}', [Penjualan::class, 'deletecart'])->name('deletecart');
    Route::post('/deleteSelectedItems', [Penjualan::class, 'deleteSelectedItems'])->name('deleteSelectedItems');
    Route::post('/update-keterangan', [Penjualan::class, 'updateKeterangan'])->name('updateKeterangan');
    Route::post('/updateQuantity/{transaksiDetailId}/{newQty}', [Penjualan::class, 'updateQuantity'])->name('update-quantity');
    Route::get('/checkout', [Penjualan::class, 'showCheckoutPage'])->name('checkout');
    Route::post('/place-order', [Penjualan::class, 'placeOrder'])->name('place.order');
    Route::post('/update-user', [Penjualan::class, 'update'])->name('updateUser');





    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/pelanggan', [Penjualan::class, 'pelanggan'])->name('pelanggan');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/editpelanggan/{id}', [Penjualan::class, 'editpelanggan'])->name('editpelanggan');
    Route::get('/deletepelanggan/{id}', [Penjualan::class, 'deletepelanggan'])->name('deletepelanggan');

    Route::get('/barang', [Penjualan::class, 'barang'])->name('barang');
    Route::post('/addbarang', [Penjualan::class, 'addbarang'])->name('addbarang');
    Route::post('/editbarang/{id}', [Penjualan::class, 'editbarang'])->name('editbarang');
    Route::get('/deletebarang/{id}', [Penjualan::class, 'deletebarang'])->name('deletebarang');

    Route::get('/suppliers', [Penjualan::class, 'supplier'])->name('supplier');   
    Route::post('/editsupplier/{supplier_id}', [Penjualan::class, 'editsupplier'])->name('editsupplier');
    Route::get('/deletesupplier/{supplier_id}', [Penjualan::class, 'deletesupplier'])->name('deletesupplier');

    Route::get('/orders', [Penjualan::class, 'order'])->name('order');
});
