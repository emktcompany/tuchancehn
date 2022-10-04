<?php

namespace App\TuChance\Models;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    /**
     * User that logged in
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
