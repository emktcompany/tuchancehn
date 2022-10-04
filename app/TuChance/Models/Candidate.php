<?php

namespace App\TuChance\Models;

use App\TuChance\Contracts\Locateable as LocateableContract;
use App\TuChance\Eloquent\Locateable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Candidate extends Model implements LocateableContract
{
    use Locateable, SearchableTrait, SoftDeletes;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'driver_license', 'birth', 'native_language', 'others_language',
        'phone', 'cell_phone', 'years_experience', 'professional_objective',
        'professional_area', 'professional_experience', 'training_education',
        'summary', 'legacy_skills', 'references', 'subscription', 'privacy',
        'gender', 'interests', 'country_id', 'state_id', 'city_id',
        'work_experience', 'school_experiences', 'id_type', 'id_number'
    ];

    /**
     * Searchable rules.
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'users.name' => 10,
        ],
        'joins' => [
            'users' => ['candidates.user_id', 'users.id'],
        ]
    ];

    /**
     * Attributes that should be casted to Carbon instances
     * @var array
     */
    protected $dates = [
        'birth',
    ];

    /**
     * Attributes that should be casted to native types
     * @var array
     */
    protected $casts = [
        'work_experience' => 'json',
        'school_experiences' => 'json',
    ];

    /**
     * User owning the bidder
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Skills on this candidate
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('weight');
    }

    /**
     * Enrollments by this candidate
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * CV as asset
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function cv()
    {
        return $this->morphOne(Asset::class, 'assetable');
    }
}
