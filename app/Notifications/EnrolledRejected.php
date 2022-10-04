<?php

namespace App\Notifications;

use App\TuChance\Models\Enrollment;

class EnrolledRejected extends BaseNotification
{
    /**
     * The folder the messages for this notifications are stored
     * @var string
     */
    protected $translations = 'enrollment/rejected';

    /**
     * Enrollment accepted
     * @var \App\TuChance\Models\Enrollment
     */
    protected $enrollment;

    /**
     * Create a new event instance.
     * @param  \App\TuChance\Models\Enrollment $enrollment
     * @return void
     */
    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }
}
