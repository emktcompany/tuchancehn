<?php

namespace App\TuChance\Models;

use App\TuChance\Contracts\Locateable as LocateableContract;
use App\TuChance\Eloquent\Locateable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Bidder extends Model implements LocateableContract
{
    use Locateable, SearchableTrait, Sluggable, SoftDeletes;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'cell_phone', 'web', 'services', 'summary',
        'description', 'country_id', 'state_id', 'city_id', 'category_id',
        'interest_id'
    ];

    /**
     * Searchable rules.
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name'        => 10,
            'description' => 5,
        ],
    ];

    /**
     * Relations that should be eager loaded with every query
     * @var array
     */
    protected $with = ['categories'];

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
     * User owning the bidder
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Category the user will publish most opportunities
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Enrollments to opportunities by this bidder
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function enrollments()
    {
        return $this->hasManyThrough(Enrollment::class, Opportunity::class);
    }

    /**
     * Opportunities by this bidder
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
    }

    /**
     * Which categories the bidder will post opportunities on
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
