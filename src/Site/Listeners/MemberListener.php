<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\MemberCreateEvent;
use QuadStudio\Service\Site\Mail\Admin\Member\MemberCreateEmail;
use QuadStudio\Service\Site\Mail\MemberConfirmationEmail;

class MemberListener
{

    /**
     * Обработчик события:
     * Создание заявки на мероприятие
     *
     * @param MemberCreateEvent $event
     */
    public function onMemberCreate(MemberCreateEvent $event)
    {

        // Отправка автору заявки на мероприятие письма о подтверждении E-mail
        Mail::to($event->member->getAttribute('email'))->send(new MemberConfirmationEmail($event->member));

        // Отправка администратору письма при создании новой заявки на мероприятии
        Mail::to(env('MAIL_TO_ADDRESS'))->send(new MemberCreateEmail($event->member));
    }


    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            MemberCreateEvent::class,
            'QuadStudio\Service\Site\Listeners\MemberListener@onMemberCreate'
        );

    }
}