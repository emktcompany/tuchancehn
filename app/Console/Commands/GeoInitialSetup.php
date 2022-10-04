<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GeoInitialSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tuchance:geo:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install geographic data platform';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('migrate', [
            '--force' => true,
            '--database' => 'geographic',
            '--path' => 'database/migrations/countries',
        ]);

        $this->laravel['db']
            ->connection('geographic')
            ->unprepared(
                $this->laravel['files']->get(
                    base_path('database/dumps/country_states_cities.sql')
                )
            );
    }
}
