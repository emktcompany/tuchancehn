<?php

namespace App\TuChance\Eloquent;

use App\TuChance\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait Ownable
{
    /**
     * User that created the resource
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Filter query by user
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed                                 $user
     * @return void
     */
    public function scopeByUser(Builder $query, $user)
    {
        $query->where('user_id', $user instanceof User ? $user->id : $user);
    }

    /**
     * Wheter the current model instance belongs to the authenticated user
     * @param  string|null  $guard
     * @return boolean
     */
    public function isMine($guard = null)
    {
        return $this->getAttribute('user_id') == auth($guard)->id();
    }

    /**
     * Filter query to only include resources by authenticated user
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|null                           $guard
     * @return void
     */
    public function scopeMine(Builder $query, $guard = null)
    {
        $query->byUser(auth($guard)->id() ?: 0);
    }

    /**
     * Boot the trait
     * @return void
     */
    public static function bootOwnable()
    {
        static::creating(function ($resource) {
            if (!$resource->user_id) {
                $resource->user_id = auth()->id();
            }
        });
    }
}
