<?php

use App\Database\Migrations\CounterMigration;

class AddCountersToOpportunitiesTable extends CounterMigration
{

    /**
     * The counters to add
     * @var array
     */
    protected $_counters = [
        'enrollment_count',
        'enrollment_accepted_count',
        'enrollment_fulfilled_count'
    ];

    /**
     * The table modified by the migration
     * @var string
     */
    protected $_table_name = 'opportunities';
}
