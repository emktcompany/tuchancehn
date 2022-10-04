<?php

namespace App\Listeners;

use App\Events\BidderAccepted;

class UpdateBidderAcceptedCounters
{
    /**
     * Handle the event.
     * @param  BidderAccepted  $event
     * @return void
     */
    public function handle(BidderAccepted $event)
    {
        $bidder  = $event->getBidder();
        $country = $bidder->country;

        $country->bidder_accepted_count = $bidder->byCountry($country->code)
            ->where('is_active', 1)
            ->count();
        $country->timestamps = false;
        $country->save();
    }
}
