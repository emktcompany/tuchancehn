<?php

$router->name('faqs')
    ->prefix('faqs')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'FaqsController@index')
            ->name('.index');
    });
