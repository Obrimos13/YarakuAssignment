<?php

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


// returns the home page with all posts


Route::get('/', BookController::class .'@index')->name('books.index');
// returns the form for adding a post
Route::get('/books/create', BookController::class . '@create')->name('books.create');
// adds a post to the database
Route::post('/books', BookController::class .'@store')->name('books.store');
// returns a page that shows a full post// returns the form for editing a post
Route::get('/books/{book}/edit', BookController::class .'@edit')->name('books.edit');
// updates a post
Route::put('/books/{book}', BookController::class .'@update')->name('books.update');
// deletes a post
Route::delete('/books/{book}', BookController::class .'@destroy')->name('books.destroy');

Route::get('books/search/{column}', BookController::class .'@search')->name('books.search');

Route::get('books/export', BookController::class .'@export')->name('books.export');

