<?php

namespace App\TuChance\Models;

use App\TuChance\Contracts\Locateable as LocateableContract;
use App\TuChance\Contracts\Taggable as TaggableContract;
use App\TuChance\Eloquent\Locateable;
use App\TuChance\Eloquent\Taggable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Carbon\Carbon;

class Opportunity extends Model implements LocateableContract, TaggableContract
{
    use Locateable, SearchableTrait, Sluggable, SoftDeletes, Taggable;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'name', 'summary', 'description', 'requirements', 'characteristics',
        'country_id', 'state_id', 'city_id', 'bidder_id', 'category_id',
        'begin_at', 'finish_at', 'allow_apply', 'link', 'subcategory_id',
    ];

    /**
     * Attributes that should be casted to Carbon instances
     * @var array
     */
    protected $dates = [
        'begin_at', 'finish_at',
    ];

    /**
     * Searchable rules.
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'opportunities.name'        => 10,
            'opportunities.description' => 10,
            'bidders.name'              => 5,
        ],
        'joins'   => [
            'bidders' => ['bidders.id', 'opportunities.bidder_id'],
        ],
    ];

    /**
     * Return the sluggable configuration array for this model.
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * Image as asset
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()
    {
        return $this->morphOne(Asset::class, 'assetable');
    }

    /**
     * Bidder owning the opportunity
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bidder()
    {
        return $this->belongsTo(Bidder::class);
    }

    /**
     * Category the opportunity belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Filter results to only include active Opportunities with an active Bidder
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  boolean                               $active
     * @return void
     */
    public function scopeVisible(Builder $query, $active = true)
    {
        $query->where(function (Builder $query) use ($active) {
            $query->where(function (Builder $query) use ($active) {
                $query->whereHas('bidder', function (Builder $query) use ($active) {
                    $query->where('bidders.is_active', $active ? 1 : 0);
                });
                $query->orWhereNull('bidder_id');
            });

            if ($active) {
                $query->where('opportunities.is_active', 1);
            } else {
                $query->orwhere('opportunities.is_active', 0);
            }

        });
    }

    /**
     * Filter results to only include available Opportunities on a given date
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \Carbon\Carbon                        $now
     * @return void
     */
    public function scopeAvailable(Builder $query, Carbon $now = null)
    {
        $query->where(function ($query) use ($now) {
            if (!$now) {
                $now = Carbon::now();
            }

            $query->where(function ($query) use ($now) {
                $query->whereNull('begin_at')
                    ->orWhere('begin_at', '<=', $now);
            });

            $query->where(function ($query) use ($now) {
                $query->whereNull('finish_at')
                    ->orWhere('finish_at', '>=', $now);
            });
        });
    }

    /**
     * Filter results to only include available Opportunities on a given date
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \Carbon\Carbon                        $now
     * @return void
     */
    public function scopeNotAvailable(Builder $query, Carbon $now = null)
    {
        $query->where(function ($query) use ($now) {
            if (!$now) {
                $now = Carbon::now();
            }

            $query->where(function ($query) use ($now) {
                $query->where('begin_at', '>=', $now);
                $query->orWhere('finish_at', '<=', $now);
            });
        });
    }

    /**
     * Filter results to only include visible Opportunities
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeActive(Builder $query)
    {
        $query->visible()
            ->available();
    }

    /**
     * Enrollments for this opportunity
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Skills on this opportunity
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    /**
     * Filter results to only include active Opportunities the candidate has
     * enrolled to
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeEnrolled(Builder $query, $candidate_id)
    {
        $query->select('enrollments.is_accepted')
            ->addSelect('opportunities.*')
            ->join('enrollments', 'opportunities.id', '=', 'enrollments.opportunity_id')
            ->where('enrollments.candidate_id', $candidate_id);
    }

    public function getIsValidAttribute()
    {
        $now       = Carbon::now();
        $begin_at  = $this->getAttribute('begin_at');
        $finish_at = $this->getAttribute('finish_at');
        return ($begin_at ? $now->gte($begin_at) : true) &&
            ($finish_at ? $now->lte($finish_at) : true);
    }

    public function getIsExpiredAttribute()
    {
        $now       = Carbon::now();
        $finish_at = $this->getAttribute('finish_at');
        return $finish_at ? $now->gt($finish_at) : false;
    }

    public function getIsUpcomingAttribute()
    {
        $now       = Carbon::now();
        $begin_at  = $this->getAttribute('begin_at');
        return $begin_at ? $now->lt($begin_at) : false;
    }
}
