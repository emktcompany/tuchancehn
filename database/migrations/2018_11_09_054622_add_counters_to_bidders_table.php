<?php

use App\Database\Migrations\CounterMigration;

class AddCountersToBiddersTable extends CounterMigration
{
    /**
     * @inheritdoc
     */
    protected $_counters = [
        'opportunity_count',
        'enrollment_count',
        'enrollment_accepted_count',
        'enrollment_fulfilled_count',
    ];

    /**
     * @inheritdoc
     */
    protected $_table_name = 'bidders';
}
