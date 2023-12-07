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
    $router->post('/login', 'AuthController@login');
    $router->post('/register', 'AuthController@register');

    $router->group(['middleware' => 'authenticator'], function () use ($router) {

        $router->group(['prefix' => 'users'], function () use ($router) {
            $router->get('', 'UserController@index');
        });

        $router->group(['prefix' => 'companies'], function () use ($router) {
            $router->get('', 'CompanyController@index');
        });

        $router->group(['prefix' => 'tasks'], function () use ($router) {
            $router->get('', 'TaskController@index');
            $router->get('/balance', 'TaskController@balance');
            $router->get('{id}', 'TaskController@show');
            $router->post('', 'TaskController@store');
            $router->put('{id}', 'TaskController@update');
            $router->delete('{id}', 'TaskController@destroy');
        });
    });
});