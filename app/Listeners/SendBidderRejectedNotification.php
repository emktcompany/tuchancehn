<?php

namespace App\Listeners;

use App\Events\BidderRejected;
use App\Notifications\BidderRejected as Notification;

class SendBidderRejectedNotification
{
    /**
     * Handle the event.
     * @param  \App\Events\BidderRejected  $event
     * @return void
     */
    public function handle(BidderRejected $event)
    {
        $bidder = $event->getBidder();

        if ($bidder->user) {
            $bidder->user->notify(new Notification($bidder));
        }
    }
}
