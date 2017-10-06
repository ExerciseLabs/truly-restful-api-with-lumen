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

$router->post('/user', 'UserController@store');

$router->get('/user/{id}', 'UserController@find')
->put('/user/{id}', 'UserController@update')
->patch('/user/{id}', 'UserController@update')
->delete('/user/{id}', 'UserController@delete');

$router->get('/users', 'UserController@index');
