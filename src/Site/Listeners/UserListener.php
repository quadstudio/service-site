<?php

namespace QuadStudio\Service\Site\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\UserScheduleEvent;
use QuadStudio\Service\Site\Mail\Admin\User\UserRegisteredEmail;
use QuadStudio\Service\Site\Mail\User\UserConfirmationEmail;

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
     * @param UserScheduleEvent $event
     */
    public function onUserAuthorized(UserScheduleEvent $event)
    {
        $event->user->schedules()->create([
            'action_id' => 1,
            'url'       => preg_split("/:\/\//", route('api.users.show', $event->user))[1]
        ]);
        //Schedule::create();
    }

    /**
     * События при регистрации сервисного центра на сайте
     * @param UserScheduleEvent $event
     */
    public function onUserRegistered(UserScheduleEvent $event)
    {

        // Отправка сервисному центру письма о подтверждении E-mail
        Mail::to($event->user->getEmailForPasswordReset())->send(new UserConfirmationEmail($event->user));

        // Отправка администратору письма о регистрации сервисного центра
        Mail::to(env('MAIL_TO_ADDRESS'))->send(new UserRegisteredEmail($event->user));

    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {

        $events->listen(
            Login::class,
            'QuadStudio\Service\Site\Listeners\UserListener@onUserLogin'
        );
        $events->listen(
            Registered::class,
            'QuadStudio\Service\Site\Listeners\UserListener@onUserRegistered'
        );
        $events->listen(
            UserScheduleEvent::class,
            'QuadStudio\Service\Site\Listeners\UserListener@onUserAuthorized'
        );
    }
}