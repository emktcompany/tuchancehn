<?php

namespace App\Console\Commands;

use App\TuChance\Models\Candidate;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FixCandidatesAge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tuchance:fix:candidates';

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
        Candidate::withTrashed()->get()
            ->each(function ($candidate) {
                if ($candidate->birth) {
                    $age = Carbon::now()
                        ->diffInYears($candidate->birth);

                    $age_range = floor($age / 10) * 10;

                    $candidate->age       = $age;
                    $candidate->age_range = "{$age_range} - " .
                        ($age_range + 9);
                } else {
                    $candidate->age       = null;
                    $candidate->age_range = null;
                }

                $candidate->timestamps = false;
                $candidate->save();
            });
    }
}
