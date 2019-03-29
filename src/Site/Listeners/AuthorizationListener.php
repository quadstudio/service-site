<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\AuthorizationCreateEvent;
use QuadStudio\Service\Site\Mail\Admin\Authorization\AuthorizationCreateEmail;

class AuthorizationListener
{

    /**
     * @param AuthorizationCreateEvent $event
     */
    public function onAuthorizationCreate(AuthorizationCreateEvent $event)
    {
        // Отправка администратору письма об оформлении новой зявки на аторизацию
        Mail::to(env('MAIL_TO_ADDRESS'))->send(new AuthorizationCreateEmail($event->authorization));

    }


    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {

        $events->listen(
            AuthorizationCreateEvent::class,
            'QuadStudio\Service\Site\Listeners\AuthorizationListener@onAuthorizationCreate'
        );

    }
}