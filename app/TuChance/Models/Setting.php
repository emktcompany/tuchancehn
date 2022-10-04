<?php

namespace App\TuChance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Carbon\Carbon;

class Setting extends Model
{
    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'value', 'type', 'cast', 'label', 'key', 'options',
    ];

    /**
     * Attributes that should be casted to native types
     * @var array
     */
    protected $casts = [
        'options' => 'json',
    ];

    public function getValueAttribute($value)
    {
        switch ($this->getAttribute('cast')) {
            case 'int':
                return (int) $value;
                break;
            case 'array':
            case 'json':
                return json_decode($value);
                break;
            case 'date':
                return new Carbon($value);
                break;
            case 'string':
                return (string) $value;
                break;
            case 'html':
                return new HtmlString($value);
                break;
        }

        return $value;
    }

    public function setValueAttribute($value)
    {
        switch ($this->getAttribute('cast')) {
            case 'array':
            case 'json':
                $value = json_encode($value);
                break;
            case 'date':
                $value = (new Carbon($value))->toIso8601String();
                break;
        }

        $this->attributes['value'] = $value;
    }
}
