<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router = app('router');

$router->group(['prefix' => 'admin', 'middleware' => 'admin'], function () use ($router) {
    $router->get('/', ['uses' => 'Admin\Controllers\AdminController@index']);

    $router->get('/users', ['uses' => 'Admin\Controllers\AdminController@users']);
    $router->get('/users/{id}/edit', ['uses' => 'Admin\Controllers\AdminController@editUser']);
    $router->post('/users/{id}/update', ['uses' => 'Admin\Controllers\AdminController@updateUser']);
    $router->post('/users/{id}/ban', ['uses' => 'Admin\Controllers\AdminController@banUser']);
    $router->post('/users/{id}/unban', ['uses' => 'Admin\Controllers\AdminController@unbanUser']);

    $router->get('/questions', ['uses' => 'Admin\Controllers\AdminController@questions']);
    $router->post('/questions/{id}/delete', ['uses' => 'Admin\Controllers\AdminController@deleteQuestion']);

    $router->get('/answers', ['uses' => 'Admin\Controllers\AdminController@answers']);
    $router->post('/answers/{id}/delete', ['uses' => 'Admin\Controllers\AdminController@deleteAnswer']);
});
