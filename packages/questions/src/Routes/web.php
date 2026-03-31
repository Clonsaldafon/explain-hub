<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router = app('router');

$router->get('/questions', ['middleware' => 'auth', 'uses' => 'Questions\Controllers\QuestionController@index']);