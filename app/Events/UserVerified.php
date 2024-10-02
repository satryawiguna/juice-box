<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserVerified
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public object $user;

    /**
     * Create a new event instance.
     */
    public function __construct(object $user)
    {
        $this->user = $user;
    }
}
