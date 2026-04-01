<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router = app('router');

$router->get('/login', 'Users\Controllers\AuthController@showLoginForm');
$router->post('/login', 'Users\Controllers\AuthController@login');
$router->get('/register', 'Users\Controllers\AuthController@showRegisterForm');
$router->post('/register', 'Users\Controllers\AuthController@register');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/logout', 'Users\Controllers\AuthController@logout');
    $router->get('/profile', 'Users\Controllers\ProfileController@index');
});