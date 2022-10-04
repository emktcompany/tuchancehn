<?php

namespace App\TuChance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Faq extends Model
{
    use SoftDeletes, SearchableTrait;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = ['question', 'answer', 'is_active', 'type'];

    /**
     * Searchable rules.
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'question' => 10,
        ]
    ];
}
