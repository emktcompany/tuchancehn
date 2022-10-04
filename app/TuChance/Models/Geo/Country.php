<?php

namespace App\TuChance\Models\Geo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Country extends Model
{
    use SearchableTrait;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'geographic';

    /**
     * Searchable rules.
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name'    => 8,
            'name_en' => 8,
            'iso'     => 10,
            'iso3'    => 10,
        ]
    ];

    /**
     * States in this country
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }
}
