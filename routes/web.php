<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SingleImageController;
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


Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/product/create', [ProductController::class, 'create'])->name('create');
Route::post('/product/store', [ProductController::class, 'store'])->name('store');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('edit');
// Route::post('/update/{id}', [SingleImageController::class, 'update'])->name('update');
Route::get('/product/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
