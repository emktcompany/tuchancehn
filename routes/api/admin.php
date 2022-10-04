<?php

$router->name('admin.')
    ->prefix('admin')
    ->namespace('Admin')
    ->middleware('auth:api')
    ->group(function ($router) {
        $router
            ->middleware('role:admin|bidder')
            ->group(function ($router) {
                $router->get(
                    'opportunities/download',
                    'OpportunitiesController@download'
                )->name('opportunities.download');
                $router->post(
                    'opportunities/import',
                    'OpportunitiesController@import'
                )->name('opportunities.import');
                $router->post(
                    'opportunities/{opportunity}/active',
                    'OpportunitiesController@toggle'
                )->name('opportunities.toggle');
                $router->apiResource(
                    'opportunities',
                    'OpportunitiesController'
                );

                $router->get(
                    'enrollments/download',
                    'EnrollmentsController@download'
                )->name('enrollments.download');
                $router->post(
                    'enrollments/{enrollment}/accepted',
                    'EnrollmentsController@toggleAccepted'
                )->name('enrollments.accepted');
                $router->post(
                    'enrollments/{enrollment}/fullfilled',
                    'EnrollmentsController@toggleFullfilled'
                )->name('enrollments.fullfilled');
                $router->apiResource('enrollments', 'EnrollmentsController', [
                    'only' => ['index', 'update'],
                ]);

                $router->get('stats/opportunities/categories', 'StatsController@opportunitiesByCategory')
                    ->name('stats.opportunities.categories');
            });

        $router
            ->middleware('role:admin|bidder')
            ->prefix('stats')
            ->namespace('Stats')
            ->name('stats.')
            ->group(function ($router) {
                $router->get('dashboard', 'DashboardController@index')
                    ->name('dashboard');

                $router->get('opportunities', 'OpportunitiesController@index')
                    ->name('opportunities');
                $router->get('bidders', 'BiddersController@index')
                    ->name('bidders');
                $router->get('candidates', 'CandidatesController@index')
                    ->name('candidates');
                $router->get('enrollments', 'EnrollmentsController@index')
                    ->name('enrollments');
            });

        $router
            ->middleware('role:admin')
            ->group(function ($router) {
                $router->apiResource('partners', 'PartnersController');

                $router->post('users/{user}/active', 'UsersController@toggle')
                    ->name('users.toggle');
                $router->apiResource('users', 'UsersController');

                $router->post(
                    'banners/{banner}/active',
                    'BannersController@toggle'
                )->name('banners.toggle');
                $router->get(
                    'banners/sort',
                    'BannersController@sortable'
                )->name('banners.sortable');
                $router->put(
                    'banners/sort',
                    'BannersController@sort'
                )->name('banners.sort');
                $router->apiResource('banners', 'BannersController');

                $router->get(
                    'bidders/download',
                    'BiddersController@download'
                )->name('bidders.download');
                $router->post(
                    'bidders/{bidder}/active',
                    'BiddersController@toggle'
                )->name('bidders.toggle');
                $router->post(
                    'bidders/{bidder}/reject',
                    'BiddersController@reject'
                )->name('bidders.reject');
                $router->apiResource('bidders', 'BiddersController');

                $router->get(
                    'candidates/download',
                    'CandidatesController@download'
                )->name('candidates.download');
                $router->post(
                    'candidates/import',
                    'CandidatesController@import'
                )->name('candidates.import');
                $router->post(
                    'candidates/{candidate}/active',
                    'CandidatesController@toggle'
                )->name('candidates.toggle');
                $router->apiResource('candidates', 'CandidatesController');

                $router->post(
                    'categories/{category}/active',
                    'CategoriesController@toggle'
                )->name('categories.toggle');
                $router->get(
                    'categories/sort',
                    'CategoriesController@sortable'
                )->name('categories.sortable');
                $router->put(
                    'categories/sort',
                    'CategoriesController@sort'
                )->name('categories.sort');
                $router->apiResource('categories', 'CategoriesController');

                $router->apiResource('email-templates', 'EmailTemplatesController');
                $router->apiResource('interests', 'InterestsController');
                $router->apiResource('skills', 'SkillsController');
                $router->apiResource('faqs', 'FaqsController');
                $router->apiResource('posts', 'PostsController');

                $router->post(
                    'testimonials/{testimonial}/active',
                    'TestimonialsController@toggle'
                )->name('testimonials.toggle');
                $router->get(
                    'testimonials/sort',
                    'TestimonialsController@sortable'
                )->name('testimonials.sortable');
                $router->put(
                    'testimonials/sort',
                    'TestimonialsController@sort'
                )->name('testimonials.sort');
                $router->apiResource('testimonials', 'TestimonialsController');

                $router->apiResource('settings', 'SettingsController', [
                    'only' => ['index', 'update'],
                ]);
            });
    });
