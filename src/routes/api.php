<?php

use Illuminate\Http\Request;

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

//Gets all Books
Route::get('Books', [BookController::class, 'index']);
//Puts new book
Route::post('Books', [BookController::class, 'store']);

Route::put('Books/{id}', [BookController::class, 'update']);
Route::delete('Books/{id}', [BookController::class, 'destroy']);
