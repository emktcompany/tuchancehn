<?php

namespace App\TuChance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'original_filename', 'extension', 'filesize', 'mime', 'path', 'meta',
        'kind',
    ];

    /**
     * Attribute that should be casted to native types
     * @var array
     */
    protected $casts = [
        'meta' => 'json',
    ];

    /**
     * Resource related to the asset
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function assetable()
    {
        return $this->morphTo();
    }
}
