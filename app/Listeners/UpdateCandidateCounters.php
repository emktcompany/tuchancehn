<?php

namespace App\Listeners;

use App\Events\CandidateCreated;

class UpdateCandidateCounters
{
    /**
     * Handle the event.
     * @param  CandidateCreated  $event
     * @return void
     */
    public function handle(CandidateCreated $event)
    {
        $candidate = $event->getCandidate();
        $country   = $candidate->country;

        $country->candidate_count = $candidate->byCountry($country->code)
            ->count();
        $country->timestamps = false;
        $country->save();
    }
}
