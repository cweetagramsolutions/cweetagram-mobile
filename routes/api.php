<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('ussd', \App\Http\Controllers\Api\UssdController::class);
Route::get('dataset/entries', [\App\Http\Controllers\Api\DashboardDataSetController::class, 'logCounts']);
Route::get('dataset/daily/{month}', [\App\Http\Controllers\Api\DashboardDataSetController::class, 'dailyCounts']);
Route::get('dataset/list/entries', [\App\Http\Controllers\Api\DashboardDataSetController::class, 'entriesList']);
Route::get('dataset/age/stats', [\App\Http\Controllers\Api\DashboardDataSetController::class, 'ageStats']);
Route::get('dataset/region/stats', [\App\Http\Controllers\Api\DashboardDataSetController::class, 'regionStats']);
