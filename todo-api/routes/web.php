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

use Illuminate\Http\JsonResponse;

$router->get('/', function () use ($router): JsonResponse {
    return new JsonResponse([
        'message' => 'OK',
        'data' => [
            'api_version' => '1.1.0',
            'framework_version' => $router->app->version(),
        ]
    ]);
});

$router->post('/login', 'AuthController@login');

$router->group(['middleware' => 'auth'], function ($router) {
    $router->get('/logout', 'AuthController@logout');
    $router->get('/task', 'TaskController@search');
    $router->post('/task', 'TaskController@create');
    $router->patch('/task/{id}', 'TaskController@update');
    $router->delete('/task/{id}', 'TaskController@delete');
});
