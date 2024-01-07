<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransaksiController;
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
    return view('welcome');
});

Route::get('/', function () {
    return view('main');
})->name('main');

Route::prefix('/product')->name('product.')->group(function(){
    Route::get('/', [ProductController::class,'index'])->name('index');
    Route::get('/create',[ProductController::class,'create'])->name('create');
    Route::get('/show',[ProductController::class,'show'])->name('show');
    Route::post('/store',[ProductController::class,'store'])->name('store');
    Route::get('/edit/{id}', [ProductController::class,'edit'])->name('edit');
    Route::put('/update/{id}',[ProductController::class,'update'])->name('update');
    Route::delete('/delete/{id}',[ProductController::class,'destroy'])->name('delete');
});

Route::prefix('/transaksi')->name('transaksi.')->group(function(){
    Route::get('/',[TransaksiController::class,'index'])->name('index');
    Route::get('/edit/{id}',[TransaksiController::class,'edit'])->name('edit');
    Route::put('/update/{id}',[TransaksiController::class,'update'])->name('update');
    Route::get('/create',[TransaksiController::class,'create'])->name('create');
    Route::post('/store',[TransaksiController::class,'store'])->name('store');
    Route::delete('/delete/{id}',[TransaksiController::class,'destroy'])->name('delete');
});
