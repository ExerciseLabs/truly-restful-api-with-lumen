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

$router->post('/user', 'AuthController@store');

$router->get('/user/{id}', 'AuthController@find')
->put('/user/{id}', 'AuthController@update')
->patch('/user/{id}', 'AuthController@update')
->delete('/user/{id}', 'AuthController@delete');

$router->get('/users', 'UserController@index');
