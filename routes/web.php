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

$router->group(['prefix' => 'account_data'], function () use ($router) {
    $router->get('/', 'AccountDataController@getAll');
    $router->get('/{id}', 'AccountDataController@find');
    $router->post('/', 'AccountDataController@create');
    $router->post('/{id}', 'AccountDataController@update');
    $router->delete('/{id}', 'AccountDataController@delete');
});

$router->group(['prefix' => 'rol'], function () use ($router) {
    $router->get('/', 'rolController@getAll');
    $router->get('/{id}', 'rolController@find');
    $router->post('/', 'rolController@create');
    $router->post('/{id}', 'rolController@update');
    $router->delete('/{id}', 'rolController@delete');
});

$router->group(['prefix' => 'permission'], function () use ($router) {
    $router->get('/', 'permissionController@getAll');
    $router->get('/{id}', 'permissionController@find');
    $router->post('/', 'permissionController@create');
    $router->post('/{id}', 'permissionController@update');
    $router->delete('/{id}', 'permissionController@delete');
});

$router->group(['prefix' => 'task_type'], function () use ($router) {
    $router->get('/', 'TaskTypeController@getAll');
    $router->get('/{id}', 'TaskTypeController@find');
    $router->post('/', 'TaskTypeController@create');
    $router->post('/{id}', 'TaskTypeController@update');
    $router->delete('/{id}', 'TaskTypeController@delete');
});