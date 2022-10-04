<?php

namespace App\Console\Commands;

use App\TuChance\Models\Bidder;
use Illuminate\Console\Command;

class FixBiddersCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tuchance:fix:bidders';

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
        (new Bidder)->withTrashed()
            ->get()
            ->each(function ($bidder) {
                if (!$bidder->category_id) {
                    $bidder->category_id = app('db')
                        ->table('report_opportunities')
                        ->where('bidder_id', $bidder->id)
                        ->selectRaw('count(*) as total')
                        ->addSelect('category_id')
                        ->groupBy('category_id')
                        ->orderBy('total', 'desc')
                        ->get()
                        ->pluck('category_id')
                        ->first();
                }

                $bidder->timestamps = false;
                $bidder->save();
            });
    }
}
