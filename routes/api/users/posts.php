<?php

$router->name('posts')
    ->prefix('posts')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'PostsController@index')
            ->name('.index');

        $router->get('{post}', 'PostsController@show')
            ->name('.show');
    });
