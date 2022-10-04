<?php

namespace App\TuChance\Eloquent;

use App\TuChance\Models\City;
use App\TuChance\Models\State;

trait Locateable
{
    use BelongsToCountry;

    /**
     * State related to the resource
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * City related to the resource
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
