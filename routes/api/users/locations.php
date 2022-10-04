<?php

$router->name('locations')
    ->prefix('locations')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'LocationsController@index')
            ->name('.index');

        $router->get('countries', 'LocationsController@countries')
            ->name('.countries');

        $router->get('states', 'LocationsController@states')
            ->name('.states');

        $router->get('cities', 'LocationsController@cities')
            ->name('.cities');
    });

$router->name('geo')
    ->prefix('geo')
    ->namespace('Geo')
    ->group(function ($router) {
        $router->get('countries', 'LocationsController@countries')
            ->name('.countries');

        $router->get('states', 'LocationsController@states')
            ->name('.states');

        $router->get('cities', 'LocationsController@cities')
            ->name('.cities');
    });
