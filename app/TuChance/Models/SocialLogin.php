<?php

namespace App\TuChance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialLogin extends Model
{
    use SoftDeletes;

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = ['network', 'network_id'];

    /**
     * User authenticated by it
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
