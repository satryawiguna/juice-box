<?php

namespace App\Events;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Events\Dispatchable;

class UserNotification extends Verified
{
    use Dispatchable;
}
