<?php

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

$router->group(['prefix' => 'account_status'], function () use ($router) {
    $router->get('/', 'AccountStatusController@getAll');
    $router->get('/{id}', 'AccountStatusController@find');
    $router->post('/', 'AccountStatusController@create');
    $router->post('/{id}', 'AccountStatusController@update');
    $router->delete('/{id}', 'AccountStatusController@delete');
});

$router->group(['prefix' => 'type_log'], function () use ($router) {
    $router->get('/', 'TypeLogController@getAll');
    $router->get('/{id}', 'TypeLogController@find');
    $router->post('/', 'TypeLogController@create');
    $router->post('/{id}', 'TypeLogController@update');
    $router->delete('/{id}', 'TypeLogController@delete');
});