<?php

$router->name('bidders')
    ->prefix('bidders')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'BiddersController@index')
            ->name('.index');

        $router->get('featured', 'BiddersController@featured')
            ->name('.featured');

        $router->get('{bidder}', 'BiddersController@show')
            ->name('.show');
    });
