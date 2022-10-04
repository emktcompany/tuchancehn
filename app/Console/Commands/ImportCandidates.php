<?php

namespace App\Console\Commands;

use App\Console\ImportCommand;
use App\TuChance\Models\User;

class ImportCandidates extends ImportCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tuchance:import:candidates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import candidates from old database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user_ids = (new User)->withTrashed()->pluck('id')->toArray();

        $this->importTable(function () use ($user_ids) {
            return $this->import_connection
                ->table('candidates')
                ->select([
                    'candidates.*', 'users.country_id', 'users.city_id',
                    'users.state_id',
                ])
                ->whereIn('user_id', $user_ids)
                ->leftJoin('users', 'users.id', '=', 'candidates.user_id')
                ->orderBy('candidates.id');
        }, 'candidates', [
            'except' => ['last_login_at'],
            'map'    => [
                'skills' => 'legacy_skills',
                'image'  => function ($row) {
                    if ($value = $row->get('image')) {
                        $user     = new User;
                        $user->id = $row->get('user_id');

                        $asset = $this->importAsset($user, 'avatar', $value);
                    }

                    return false;
                },
                'birth'  => function ($row) {
                    $value = $row->get('birth');

                    if (starts_with($value, '0000')) {
                        return null;
                    }

                    return $value;
                },
            ],
        ]);
    }
}
