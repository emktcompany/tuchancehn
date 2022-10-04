<?php

namespace App\TuChance\Models\Geo;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class City extends Model
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
            'name' => 8,
        ]
    ];
}
