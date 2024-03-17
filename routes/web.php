<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SymbolController;
use App\Http\Controllers\Auth\UserController;

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

Route::post('/transaction', [SymbolController::class, 'getTransaction'])->name('transaction');
Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();
Route::get('/account', [UserController::class, 'index'])->middleware('auth')->name('account');
Route::put('/account/update', [UserController::class, 'update'])->middleware('auth')->name('account.update');
Route::delete('/account/destroy', [UserController::class, 'destroy'])->middleware('auth')->name('account.destroy');
