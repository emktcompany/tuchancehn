<?php

$router->name('api.v1.')
    ->prefix('v1')
    ->group(function ($router) {
        require_once base_path('routes/api/admin.php');

        require_once base_path('routes/api/auth/account.php');
        require_once base_path('routes/api/auth/auth.php');
        require_once base_path('routes/api/auth/passwords.php');
        require_once base_path('routes/api/auth/register.php');

        require_once base_path('routes/api/users/banners.php');
        require_once base_path('routes/api/users/bidders.php');
        require_once base_path('routes/api/users/categories.php');
        require_once base_path('routes/api/users/interests.php');
        require_once base_path('routes/api/users/locations.php');
        require_once base_path('routes/api/users/opportunities.php');
        require_once base_path('routes/api/users/partners.php');
        require_once base_path('routes/api/users/posts.php');
        require_once base_path('routes/api/users/faqs.php');
        require_once base_path('routes/api/users/settings.php');
        require_once base_path('routes/api/users/skills.php');
        require_once base_path('routes/api/users/testimonials.php');
    });
