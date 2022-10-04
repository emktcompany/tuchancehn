<?php

$router->name('partners')
    ->prefix('partners')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'PartnersController@index')
            ->name('.index');
    });
