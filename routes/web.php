<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SymbolController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [IndexController::class, 'showIndex']);
Route::post('/transaction', [SymbolController::class, 'getTransaction'])->name('transaction');

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

// マイページ
Route::get('/myPage', 'App\Http\Controllers\myPageController@myPage')->name('myPage')->middleware('verified');
