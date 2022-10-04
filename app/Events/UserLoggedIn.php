<?php

namespace App\Events;

use App\TuChance\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLoggedIn
{
    use Dispatchable, SerializesModels;

    /**
     * User that logged in
     * @var \App\TuChance\Models\User
     */
    protected $user;

    /**
     * Create a new event instance.
     * @param  \App\TuChance\Models\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the user that logged in
     * @return \App\TuChance\Models\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
