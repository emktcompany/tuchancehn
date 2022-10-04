<?php

$router->name('auth.')
    ->prefix('auth')
    ->namespace('Auth')
    ->group(function ($router) {
        $router->post('login', 'AuthController@login')
            ->name('login');

        $router->post('google', 'AuthController@google')
            ->name('google');

        $router->post('facebook', 'AuthController@facebook')
            ->name('facebook');

        $router->post('logout', 'AuthController@logout')
            ->middleware('auth:api')
            ->name('logout');

        $router->post('refresh', 'AuthController@refresh')
            ->middleware('auth:api')
            ->name('refresh');
    });
