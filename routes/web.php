<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => '/product', 'middleware'=>'auth'], function (){
    
    Route::get('list', [ProductController::class, 'index'])->name('products.index');
    Route::get('fetch', [ProductController::class, 'fetchProduct']);
    
    Route::get('create', [ProductController::class, 'create']);
    Route::post('store', [ProductController::class, 'store']);
    
    Route::get('edit/{id}', [ProductController::class, 'edit']);
    Route::post('update/{id}', [ProductController::class, 'update']);
    
    Route::get('destroy/{id}', [ProductController::class, 'destroy']);

});