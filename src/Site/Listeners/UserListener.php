<?php

namespace QuadStudio\Service\Site\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Events\Dispatcher;
use QuadStudio\Service\Site\Events\UserExport;
use QuadStudio\Service\Site\Models\Schedule;

class UserListener
{

    /**
     * @param Login $event
     */
    public function onUserLogin(Login $event)
    {
        $event->user->logged_at = Carbon::now();
        $event->user->save();
    }

    /**
     * @param UserExport $event
     */
    public function onUserAuthorized(UserExport $event)
    {
        Schedule::create([
            'action_id' => 1,
            'url' => preg_split("/:\/\//", route('api.users.show', $event->user))[1]
        ]);
    }

    public function subscribe(Dispatcher $events)
    {

        $events->listen(
            Login::class,
            'QuadStudio\Service\Site\Listeners\UserListener@onUserLogin'
        );
        $events->listen(
            UserExport::class,
            'QuadStudio\Service\Site\Listeners\UserListener@onUserAuthorized'
        );
    }
}