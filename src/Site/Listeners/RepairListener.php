<?php

namespace QuadStudio\Service\Site\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Events\RepairCreateEvent;
use QuadStudio\Service\Site\Events\RepairEditEvent;
use QuadStudio\Service\Site\Events\RepairStatusEvent;
use QuadStudio\Service\Site\Mail\Admin\Repair\RepairCreateEmail;
use QuadStudio\Service\Site\Mail\Admin\Repair\RepairEditEmail;
use QuadStudio\Service\Site\Mail\User\Repair\RepairStatusEmail;

class RepairListener
{

    /**
     * Обработчик события:
     * Создание отчета по ремонту
     *
     * @param RepairCreateEvent $event
     */
    public function onRepairCreate(RepairCreateEvent $event)
    {
        // Отправка администратору письма при создании нового отчета по ремонту
        Mail::to(env('MAIL_TO_ADDRESS'))->send(new RepairCreateEmail($event->repair));
    }

    /**
     * Обработчик события:
     * Исправление отчета по ремонту
     *
     * @param RepairEditEvent $event
     */
    public function onRepairEdit(RepairEditEvent $event)
    {
        // Отправка администратору письма при исправлении отчета по ремонту
        Mail::to(env('MAIL_TO_ADDRESS'))->send(new RepairEditEmail($event->repair));
    }

    /**
     * Обработчик события:
     * Смена администратором статуса отчета по ремонту
     *
     * @param RepairStatusEvent $event
     */
    public function onRepairStatus(RepairStatusEvent $event)
    {
        // Отправка пользователю письма при смене статуса отчета по ремонту
        Mail::to($event->repair->user->email)->send(new RepairStatusEmail($event->repair, $event->adminMessage));
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            RepairCreateEvent::class,
            'QuadStudio\Service\Site\Listeners\RepairListener@onRepairCreate'
        );

        $events->listen(
            RepairEditEvent::class,
            'QuadStudio\Service\Site\Listeners\RepairListener@onRepairEdit'
        );

        $events->listen(
            RepairStatusEvent::class,
            'QuadStudio\Service\Site\Listeners\RepairListener@onRepairStatus'
        );
    }
}