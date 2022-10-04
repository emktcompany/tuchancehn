<?php

$router->name('interests')
    ->prefix('interests')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'InterestsController@index')
            ->name('.index');
    });
