<?php

$router->name('register.')
    ->prefix('register')
    ->namespace('Auth')
    ->group(function ($router) {
        $router->post('bidder', 'RegisterController@bidder')
            ->name('bidder');

        $router->post('candidate', 'RegisterController@candidate')
            ->name('candidate');
    });
