<?php

namespace App\TuChance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Skill extends Model
{
    use SoftDeletes, SearchableTrait;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = ['name', 'is_soft'];

    /**
     * Searchable rules.
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name' => 10,
        ]
    ];
}
