<?php

$router->name('categories')
    ->prefix('categories')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'CategoriesController@index')
            ->name('.index');
    });
