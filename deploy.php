<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'tuchance.iw.sv');

// Project repository
set('repository', 'git@git.iw.sv:giz/tuchance/website.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', [
    'public/css',
    'public/images',
    'public/js',
    'node_modules'
]);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts
host('staging')
    ->hostname('46.101.134.217')
    ->stage('staging')
    ->user('tuchance')
    ->set('branch', 'develop')
    ->set('php_version', '7.1')
    ->set('deploy_path', '~/test');

host('devgt')
    ->hostname('104.131.130.10')
    ->stage('devgt')
    ->user('www')
    ->set('branch', 'guatemala')
    ->set('php_version', '7.1')
    ->set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader')
    ->set('deploy_path', '~/public/gt.tuchance.iw.sv');

host('prodgt')
    ->hostname('46.101.134.217')
    ->stage('prodgt')
    ->user('guatemala')
    ->set('branch', 'guatemala')
    ->set('php_version', '7.2')
    ->set('deploy_path', '~/public');

host('devsv')
    ->hostname('104.131.130.10')
    ->stage('devsv')
    ->user('www')
    ->set('branch', 'elsalvador')
    ->set('php_version', '7.1')
    ->set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader')
    ->set('deploy_path', '~/public/{{application}}');

host('prodsv')
    ->hostname('46.101.134.217')
    ->stage('prodsv')
    ->user('elsalvador')
    ->set('branch', 'elsalvador')
    ->set('php_version', '7.2')
    ->set('deploy_path', '~/public');

host('devhn')
    ->hostname('104.131.130.10')
    ->stage('devhn')
    ->user('www')
    ->set('branch', 'honduras')
    ->set('php_version', '7.1')
    ->set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader')
    ->set('deploy_path', '~/public/hn.tuchance.iw.sv');

host('prodhn')
    ->hostname('46.101.134.217')
    ->stage('prodhn')
    ->user('honduras')
    ->set('branch', 'honduras')
    ->set('php_version', '7.2')
    ->set('deploy_path', '~/public');

host('prodni')
    ->hostname('46.101.134.217')
    ->stage('prodni')
    ->user('nicaragua')
    ->set('branch', 'nicaragua')
    ->set('php_version', '7.2')
    ->set('deploy_path', '~/public');

// Tasks
desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    run('sudo /usr/sbin/service php{{php_version}}-fpm restart');
});

desc('Clean cache config');
task('yarn:build', function () {
    within('{{release_path}}', function () {
        run('yarn');
        run('yarn production --env.mixfile=webpack.pdf.mix');
        run('yarn production');
    });
});

desc('Clean cache config');
task('artisan:config:clear', function () {
    run('{{bin/php}} {{release_path}}/artisan config:clear');
});

desc('Initial setup');
task('install', [
    'artisan:geoip:update',
    'artisan:config:clear',
    'artisan:db:seed',
    'artisan:tuchance:import',
    'artisan:migrate:reports',
    'tuchance:fix:candidates',
    'tuchance:fix:bidders',
    'artisan:geo:install',
]);

desc('Migrate countries database');
task('artisan:geo:install', function () {
    run('{{bin/php}} {{release_path}}/artisan tuchance:geo:install');
    run('{{bin/php}} {{release_path}}/artisan tuchance:geo:import:countries');
});

desc('Simple pull');
task('git:pull', function () {
    within('{{release_path}}', function () {
        run('git pull origin {{branch}}');
    });
});

desc('Import from old tuchance');
task('artisan:tuchance:import', function () {
    run('{{bin/php}} {{release_path}}/artisan tuchance:import:all');
});

desc('Set under constuction code');
task('artisan:code:set', function () {
    run('{{bin/php}} {{release_path}}/artisan code:set 4038');
});

desc('Reset migrations');
task('artisan:migrate:refresh', function () {
    run('{{bin/php}} {{release_path}}/artisan migrate:refresh --force --seed');
});

desc('Candidates fix');
task('tuchance:fix:candidates', function () {
    run('{{bin/php}} {{release_path}}/artisan tuchance:fix:candidates');
});

desc('Bidders fix');
task('tuchance:fix:bidders', function () {
    run('{{bin/php}} {{release_path}}/artisan tuchance:fix:bidders');
});

desc('Report migrations');
task('artisan:migrate:reports', function () {
    run('{{bin/php}} {{release_path}}/artisan tuchance:reports:rebuild');
});

desc('Rollback migrations');
task('artisan:migrate:rollback', function () {
    run('{{bin/php}} {{release_path}}/artisan migrate:rollback --force');
});

desc('Update maxmind db');
task('artisan:geoip:update', function () {
    run('{{bin/php}} {{release_path}}/artisan geoip:update');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');
// after('deploy:symlink', 'artisan:code:set');
// after('deploy:symlink', 'yarn:build');
after('deploy:symlink', 'php-fpm:restart');
