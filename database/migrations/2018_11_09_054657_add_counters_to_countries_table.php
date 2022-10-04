<?php

use App\Database\Migrations\CounterMigration;

class AddCountersToCountriesTable extends CounterMigration
{
    /**
     * @inheritdoc
     */
    protected $_counters = [
        'candidate_count',
        'bidder_count',
        'bidder_accepted_count',
        'user_count',
        'user_bidder_count',
        'user_candidate_count',
        'opportunity_count',
        'enrollment_count',
        'enrollment_accepted_count',
        'enrollment_fulfilled_count'
    ];

    /**
     * @inheritdoc
     */
    protected $_table_name = 'countries';
}
