<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->get('/users','UsersController@index');
    $router->delete('/users/{user}','UsersController@destroy');


    $router->get('categories','CategoriesController@index');
    $router->get('categories/create','CategoriesController@create');
    $router->post('categories','CategoriesController@store');
    $router->get('categories/{category}/edit', 'CategoriesController@edit');
    $router->put('categories/{category}','CategoriesController@update');
    $router->delete('categories/{category}','CategoriesController@destroy');

    $router->get('topics','TopicsController@index');
    $router->get('topics/create','TopicsController@create');
    $router->post('topics','TopicsController@store');
    $router->get('topics/{topic}/edit', 'TopicsController@edit');
    $router->put('topics/{topic}','TopicsController@update');
    $router->delete('topics/{topic}','TopicsController@destroy');

});
