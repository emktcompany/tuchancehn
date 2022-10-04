<?php

$router->name('opportunities')
    ->prefix('opportunities')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'OpportunitiesController@index')
            ->name('.index');

        $router->get('enrolled', 'OpportunitiesController@enrolled')
            ->middleware('auth:api')
            ->middleware('role:candidate')
            ->name('.enrolled');

        $router->post('{opportunity}', 'OpportunitiesController@enroll')
            ->middleware('auth:api')
            ->middleware('role:candidate')
            ->where('opportunity', '[a-z0-9-]+')
            ->name('.enroll');

        $router->get('{opportunity}', 'OpportunitiesController@show')
            ->where('opportunity', '[a-z0-9-]+')
            ->name('.show');
    });
