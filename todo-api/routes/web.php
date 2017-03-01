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

$app->get('/', function () use ($app) {
    return [
        'message' => $app->version()
    ];
});

$app->post('/login', 'AuthController@login');

$app->group(['middleware' => 'auth'], function () use ($app) {
    $app->get('/logout', 'AuthController@logout');
    $app->get('/task', 'TaskController@search');
    $app->post('/task', 'TaskController@create');
    $app->patch('/task/{id}', 'TaskController@update');
    $app->delete('/task/{id}', 'TaskController@delete');
});
