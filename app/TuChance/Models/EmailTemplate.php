<?php

namespace App\TuChance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'event', 'days', 'title', 'content', 'cta', 'is_active', 'cta_text',
    ];

    /**
     * Attributes that should be casted to native types
     * @var array
     */
    protected $casts = [
        'content' => 'json',
    ];

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
    public function footer()
    {
        return $this->morphOne(Asset::class, 'assetable')
            ->where('kind', 'footer');
    }

    /**
     * Image as asset
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function sponsor()
    {
        return $this->morphOne(Asset::class, 'assetable')
            ->where('kind', 'sponsor');
    }
}
