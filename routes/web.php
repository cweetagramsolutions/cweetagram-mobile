<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home/entries/export', [App\Http\Controllers\HomeController::class, 'export'])->name('home.entries.export');

Route::group(['prefix' => 'winners'], function () {
    Route::get('/', [\App\Http\Controllers\WinnersController::class, 'index'])->name('winners.index');
    Route::post('/', [\App\Http\Controllers\WinnersController::class, 'postDraw'])->name('winners.draw.post');
    Route::get('/draw/{id}', [\App\Http\Controllers\WinnersController::class, 'draw'])->name('winners.draw');
    Route::get('/export/draw/{id}', [\App\Http\Controllers\WinnersController::class, 'export'])->name('winners.draw.export');
    Route::put('/draw/state/{id}', [\App\Http\Controllers\WinnersController::class, 'updateState'])->name('winners.draw.update_state');
});
