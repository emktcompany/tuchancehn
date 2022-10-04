<?php

namespace App\TuChance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Enrollment extends Model
{
    use SoftDeletes, SearchableTrait;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'opportunity_id',
    ];

    /**
     * Searchable rules.
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'opportunities.name' => 10,
            'users.name'         => 10,
        ],
        'joins'   => [
            'candidates'    => ['candidates.id', 'enrollments.candidate_id'],
            'users'         => ['users.id', 'candidates.user_id'],
            'opportunities' => [
                'opportunities.id', 'enrollments.opportunity_id',
            ],
        ],
    ];

    /**
     * Candidate who enrolled
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * Opportunity the Candidate enrolled to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }
}
