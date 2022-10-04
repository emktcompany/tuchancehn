<?php

$router->name('account.')
    ->prefix('account')
    ->namespace('Auth')
    ->middleware('auth:api')
    ->group(function ($router) {
        $router->put('bidder', 'AccountController@bidder')
            ->middleware('role:bidder')
            ->name('bidder');

        $router->put('candidate', 'AccountController@candidate')
            ->middleware('role:candidate')
            ->name('candidate');

        $router->put('admin', 'AccountController@admin')
            ->middleware('role:admin')
            ->name('admin');

        $router->get('me', 'AuthController@me')
            ->name('me');
    });
