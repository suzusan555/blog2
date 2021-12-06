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

Route::get('/', 'BlogController@index')->name('blog.index');
Route::get('/blog/create', 'BlogController@create')->name('blog.create');
Route::post('/blog/store', 'BlogController@store')->name('blog.store');
Route::get('/blog/{id}', 'BlogController@show')->name('blog.show');
Route::get('/blog/edit/{id}', 'BlogController@edit')->name('blog.edit');
Route::post('/blog/update', 'BlogController@update')->name('blog.update');
Route::post('/blog/delete/{id}', 'BlogController@delete')->name('blog.delete');

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
