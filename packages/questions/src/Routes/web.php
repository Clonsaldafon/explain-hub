<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router = app('router');

$router->get('/', 'Questions\Controllers\QuestionController@index');
$router->get('/questions', 'Questions\Controllers\QuestionController@index');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/questions/create', 'Questions\Controllers\QuestionController@create');
});

$router->get('/questions/{id}', 'Questions\Controllers\QuestionController@show');

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->post('/questions', 'Questions\Controllers\QuestionController@store');
    $router->get('/questions/{id}/edit', 'Questions\Controllers\QuestionController@edit');
    $router->post('/questions/{id}', 'Questions\Controllers\QuestionController@update');
    $router->delete('/questions/{id}', 'Questions\Controllers\QuestionController@destroy');

    $router->post('/questions/{questionId}/answers', 'Questions\Controllers\AnswerController@store');
    $router->get('/answers/{id}/edit', 'Questions\Controllers\AnswerController@edit');
    $router->post('/answers/{id}', 'Questions\Controllers\AnswerController@update');
    $router->delete('/answers/{id}', 'Questions\Controllers\AnswerController@destroy');
    
    $router->get('/my-questions', 'Questions\Controllers\QuestionController@myQuestions');
    $router->get('/my-answers', 'Questions\Controllers\AnswerController@myAnswers');
});

$router->group(['middleware' => 'role:editor,moderator,admin'], function () use ($router) {
    $router->patch('/questions/{id}/status', 'Questions\Controllers\QuestionController@moderate');
    $router->patch('/answers/{id}/status', 'Questions\Controllers\AnswerController@moderate');
});