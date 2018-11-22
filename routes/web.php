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

/**分页 */
Route::get('/topics_page','TopicsController@topic');
/**回复 */
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy','update']]);
/**帖子 */
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
/**SEO优化 */
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

Route::group(['middleware' => 'guest'], function () {

    /*GitHub登录*/
    Route::get('/login', 'UsersController@login')->name('login');
    Route::get('/auth/{social}', 'AuthenticationController@getSocialRedirect');
    Route::get('/auth/{social}/callback', 'AuthenticationController@getSocialCallback');
});

Route::group(['middleware' => 'auth'], function () {

    Route::post('/logout', 'UsersController@logout')->name('logout');

    /**用户 */
    Route::get('/users/{user}', 'UsersController@index')->name('users.index');
    Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
    Route::put('/users/{user}', 'UsersController@update')->name('users.update');
    Route::get('/users/{user}/message', 'UsersController@message')->name('users.message');
    /**头像 */
    Route::post('/update_avatar/{user}', 'UsersController@update_avatar')->name('update_avatar');

    Route::post('/coupons','CouponController@store')->name('users.coupons');
});

