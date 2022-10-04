<?php

use App\Database\Migrations\CounterMigration;

class AddCountersToCandidatesTable extends CounterMigration
{
    /**
     * @inheritdoc
     */
    protected $_counters = [
        'enrollment_count',
        'enrollment_accepted_count',
        'enrollment_fulfilled_count'
    ];

    /**
     * @inheritdoc
     */
    protected $_table_name = 'candidates';
}
