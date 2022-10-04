<?php

$router->name('skills')
    ->prefix('skills')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'SkillsController@index')
            ->name('.index');
    });
