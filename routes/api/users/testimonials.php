<?php

$router->name('testimonials')
    ->prefix('testimonials')
    ->namespace('Users')
    ->group(function ($router) {
        $router->get('/', 'TestimonialsController@index')
            ->name('.index');
    });
