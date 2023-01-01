<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Login $event
     * @return void
     */
    public function handle(Login $event): void
    {
        $token = auth()->guard('api')->tokenById($event->user['id']);
        $event->user->update(['api_token' => $token]);
    }
}
