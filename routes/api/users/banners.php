<?php

$router->name('banners')
    ->prefix('banners')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'BannersController@index')
            ->name('.index');
    });
