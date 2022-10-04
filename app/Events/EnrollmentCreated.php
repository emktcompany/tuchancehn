<?php

namespace App\Events;

use App\TuChance\Models\Enrollment;
use Illuminate\Queue\SerializesModels;

class EnrollmentCreated
{
    use SerializesModels;

    /**
     * Enrollment created
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

    /**
     * Get the enrollment
     * @return \App\TuChance\Models\Enrollment
     */
    public function getEnrollment()
    {
        return $this->enrollment;
    }
}
