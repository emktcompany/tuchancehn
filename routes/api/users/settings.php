<?php

$router->name('settings')
    ->prefix('settings')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'SettingsController@index')
            ->name('.index');
    });
