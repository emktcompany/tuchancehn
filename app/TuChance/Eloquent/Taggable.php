<?php

namespace App\TuChance\Eloquent;

use App\TuChance\Models\Interest;

trait Taggable
{
    /**
     * Country related to the resource
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Interest::class, 'taggable');
    }
}
