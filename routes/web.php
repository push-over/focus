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

Route::get('/users/{user}/home', 'UsersController@home')->name('users.home');

Route::group(['middleware' => 'guest'], function () {

    /*GitHub登录*/
    Route::get('/login', 'UsersController@login')->name('login');
    Route::get('/auth/{social}', 'AuthenticationController@getSocialRedirect');
    Route::get('/auth/{social}/callback', 'AuthenticationController@getSocialCallback');
});

Route::group(['middleware' => 'auth'], function () {

    Route::post('/logout', 'UsersController@logout')->name('logout');

    /*用户模块*/
    Route::get('/users/{user}', 'UsersController@index')->name('users.index');
    Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
    Route::put('/users/{user}', 'UsersController@update')->name('users.update');
    Route::get('/users/{user}/message', 'UsersController@message')->name('users.message');

    Route::post('/update_avatar/{user}', 'UsersController@update_avatar')->name('update_avatar');

});
