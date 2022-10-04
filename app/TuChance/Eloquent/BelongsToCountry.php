<?php

namespace App\TuChance\Eloquent;

use App\TuChance\Models\Country;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToCountry
{
    /**
     * Country related to the resource
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Filter query by country code
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string                                $code
     * @return void
     */
    public function scopeByCountry(Builder $query, $code)
    {
        $query->where(function (Builder $query) use ($code) {
            $query->whereHas('country', function (Builder $query) use ($code) {
                $query->where(
                    'countries.code',
                    $code instanceof Country ? $code->code : $code
                );
            });
            $query->orWhereNull("{$this->getTable()}.country_id");
        });
    }
}
