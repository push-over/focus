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

Route::get('/', 'PagesController@index')->name('pages.index');

Route::group(['midlleware' => 'guest'], function () {
    Route::get('/login', 'UsersController@login')->name('login');

    Route::get('/auth/{social}', 'AuthenticationController@getSocialRedirect');
    Route::get('/auth/{social}/callback', 'AuthenticationController@getSocialCallback');
});

Route::group(['midlleware' => 'auth'], function () {
    Route::get('/logout', 'UsersController@logout')->name('logout');
    Route::get('/users', 'UsersController@index')->name('users.index');
    Route::get('/users/home', 'UsersController@home')->name('users.home');
    Route::get('/users/message', 'UsersController@message')->name('users.message');
    Route::get('/users/edit', 'UsersController@edit')->name('users.edit');
});
