<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    // CRUD
    $router->group(['prefix' => 'category'], function () use ($router) {
        $router->get('/', 'CategoryController@index');
        $router->get('/{id}', 'CategoryController@show');
        $router->post('/', 'CategoryController@store');
        $router->put('/{id}', 'CategoryController@update');
        $router->delete('/{id}', 'CategoryController@delete');
    });

    // CRUD
    $router->group(['prefix' => 'post'], function () use ($router) {
        $router->get('/', 'PostController@index');
        $router->get('/{id}', 'PostController@show');
        $router->post('/', 'PostController@store');
        $router->put('/{id}', 'PostController@update');
        $router->delete('/{id}', 'PostController@delete');
    });

    // CRUD firestore
    $router->group(['prefix' => 'post-firestore'], function () use ($router) {
        $router->get('/', 'PostController@indexFirestore');
        $router->get('/{id}', 'PostController@showFirestore');
        $router->post('/', 'PostController@storeFirestore');
        $router->put('/{id}', 'PostController@updateFirestore');
        $router->delete('/{id}', 'PostController@deleteFirestore');
    });
});
