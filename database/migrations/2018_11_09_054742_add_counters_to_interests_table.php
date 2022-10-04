<?php

use App\Database\Migrations\CounterMigration;

class AddCountersToInterestsTable extends CounterMigration
{
    /**
     * @inheritdoc
     */
    protected $_counters = [
        'user_count',
        'bidder_count',
        'opportunity_count',
    ];

    /**
     * @inheritdoc
     */
    protected $_table_name = 'interests';
}
