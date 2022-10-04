<?php

namespace App\Console\Commands;

use App\TuChance\Models\Country;
use App\TuChance\Models\Geo\Country as RemoteCountry;
use Illuminate\Console\Command;

class ImportCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tuchance:geo:import:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $country = (new RemoteCountry)->orderBy('name')
            ->get()
            ->each(function ($row) {
                $country = (new Country)->where(function ($query) use ($row) {
                    $query->where('remote_id', $row->id)
                        ->orWhere('code', strtolower($row->iso));
                })
                    ->firstOrNew([]);

                if ($country->exists && $country->remote_id == null) {
                    return;
                }

                $country->code      = $row->iso;
                $country->name      = $row->name;
                $country->abbr      = $row->iso3;
                $country->remote_id = $row->id;

                if ($country->isDirty()) {
                    $country->save();
                }

                $country->save();

                $row->states()
                    ->get()
                    ->each(function ($row) use ($country) {
                        $state = $country->states()
                            ->where('name', $row->name)
                            ->firstOrNew([]);

                        $state->name = $row->name;

                        if ($state->isDirty()) {
                            $state->save();
                        }

                        $row->cities()
                            ->get()
                            ->each(function ($row) use ($state) {
                                $city = $state->cities()
                                    ->where('name', $row->name)
                                    ->firstOrNew([]);

                                $city->name = $row->name;

                                if ($city->isDirty()) {
                                    $city->save();
                                };
                            });
                    });
            });
    }
}
