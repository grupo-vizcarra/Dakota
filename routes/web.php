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

$router->post('auth/login', ['uses' => 'AuthController@authenticate']);

$router->group(['middleware' => 'jwt.auth'], function () use ($router){ });
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
        $router->get('/', 'RolController@getAll');
        $router->get('/{id}', 'RolController@find');
        $router->post('/', 'RolController@create');
        $router->post('/{id}', 'RolController@update');
        $router->delete('/{id}', 'RolController@delete');
        $router->get('/{id}/permissions', 'RolController@permissions');
        $router->post('/{id}/permissions', 'RolController@updatePermissions');
        $router->post('/{id}/permission', 'RolController@togglePermission');
    });
    
    $router->group(['prefix' => 'permission'], function () use ($router) {
        $router->get('/', 'PermissionController@getAll');
        $router->get('/{id}', 'PermissionController@find');
        $router->post('/', 'PermissionController@create');
        $router->post('/{id}', 'PermissionController@update');
        $router->delete('/{id}', 'PermissionController@delete');
    });
    
    $router->group(['prefix' => 'task_type'], function () use ($router) {
        $router->get('/', 'TaskTypeController@getAll');
        $router->get('/{id}', 'TaskTypeController@find');
        $router->post('/', 'TaskTypeController@create');
        $router->post('/{id}', 'TaskTypeController@update');
        $router->delete('/{id}', 'TaskTypeController@delete');
    });
    
    
    
    $router->group(['prefix' => 'log'], function () use ($router){
        $router->get('/', 'AccountController@logs');
        $router->post('/', 'AccountController@toggleLog');
        $router->post('/refresh','AccountController@updateLogs');
    });
    
    $router->group(['prefix' => 'task'], function () use ($router){
        $router->get('/', 'AccountController@tasks');
        $router->post('/', 'AccountController@attachTask');
        $router->post('/delete', 'AccountController@dettachTask');
    });
$router->group(['prefix' => 'account'], function () use ($router) {
    $router->get('/', 'AccountController@getAll');
    $router->get('/{id:[0-9]+}', 'AccountController@find');
    $router->post('/', 'AccountController@create');
    $router->post('/{id}', 'AccountController@update');
    $router->delete('/{id}', 'AccountController@delete');
    $router->get('/permissions', 'AccountController@permissions');
    $router->post('/permissions','AccountController@updatePermissions');
    $router->post('/permission', 'AccountController@togglePermission');
});