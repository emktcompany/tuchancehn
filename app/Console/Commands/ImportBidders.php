<?php

namespace App\Console\Commands;

use App\Console\ImportCommand;
use App\TuChance\Models\User;

class ImportBidders extends ImportCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tuchance:import:bidders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import bidders from old database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->importTable(function () {
            $user_ids = User::withTrashed()->pluck('id')->toArray();

            return $this->import_connection
                ->table('bidders')
                ->whereIn('user_id', $user_ids)
                ->orderBy('bidders.id');
        }, 'bidders', [
            // 'except' => ['image'],
            'map' => [
                'name_bidder' => 'name',
                'image'       => function ($row) {
                    if ($value = $row->get('image')) {
                        $user     = new User;
                        $user->id = $row->get('user_id');

                        $asset = $this->importAsset($user, 'avatar', $value);
                    }

                    return false;
                },
            ],
        ]);

        $this->connection
            ->statement(implode(' ', [
                'update bidders set bidders.is_active = (',
                'select users.is_active from users where ',
                'users.id = bidders.user_id)',
            ]));
    }
}
