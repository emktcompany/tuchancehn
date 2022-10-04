<?php

namespace App\TuChance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Testimonial extends Model
{
    use SoftDeletes, SearchableTrait;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'name', 'body', 'is_active',
    ];

    /**
     * Searchable rules.
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name' => 10,
            'body' => 5,
        ]
    ];

    /**
     * Image as asset
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()
    {
        return $this->morphOne(Asset::class, 'assetable');
    }
}
