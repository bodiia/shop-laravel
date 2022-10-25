<?php

namespace App\Listeners;

use App\Notifications\GreetingNotification;
use Illuminate\Auth\Events\Registered;

class SendGreetingEmailToUser
{
    public function handle(Registered $event): void
    {
        $event->user->notify(new GreetingNotification());
    }
}
