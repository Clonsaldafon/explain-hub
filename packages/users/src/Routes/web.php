<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router = app('router');

$router->get('/', ['uses' => 'Users\Controllers\AuthController@showLoginForm']);
$router->get('/login', ['uses' => 'Users\Controllers\AuthController@showLoginForm']);
$router->post('/login', ['uses' => 'Users\Controllers\AuthController@login']);
$router->get('/register', ['uses' => 'Users\Controllers\AuthController@showRegisterForm']);
$router->post('/register', ['uses' => 'Users\Controllers\AuthController@register']);
$router->get('/logout', ['uses' => 'Users\Controllers\AuthController@logout']);

$router->get('/profile', ['middleware' => 'auth', 'uses' => 'Users\Controllers\ProfileController@index']);