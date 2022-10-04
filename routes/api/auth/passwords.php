<?php

$router->name('password.')
    ->prefix('password')
    ->namespace('Auth')
    ->group(function ($router) {
        $router->post('remind', 'PasswordsController@sendReminder')
            ->name('remind');

        $router->post('reset', 'PasswordsController@resetPassword')
            ->name('reset');
    });
