<?php

namespace App\TuChance\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use Sluggable, SoftDeletes;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'link', 'color', 'is_active', 'title'
    ];

    /**
     * Return the sluggable configuration array for this model.
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * subcategories
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * Image as asset
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()
    {
        return $this->morphOne(Asset::class, 'assetable')->whereNull('kind');
    }

    /**
     * Image as asset
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function banner()
    {
        return $this->morphOne(Asset::class, 'assetable')
            ->where('kind', 'banner');
    }

    /**
     * Image as asset
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function opportunity()
    {
        return $this->morphOne(Asset::class, 'assetable')
            ->where('kind', 'opportunity');
    }
}
