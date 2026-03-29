<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router = app('router');

$router->group(['namespace' => 'Users\Controllers'], function () use ($router) {
    $router->get('/login', 'AuthController@showLoginForm');
    $router->get('/register', 'AuthController@showRegisterForm');
});