<?php

namespace QuadStudio\Service\Site\Mail\User\Repair;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Repair;

class RepairStatusChangeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Repair
     */
    public $repair;

    /**
     * Create a new message instance.
     * @param Repair $repair
     * @param null $adminMessage
     */
    public function __construct(Repair $repair)
    {
        $this->repair = $repair;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(trans('site::repair.email.status_change.title'))
            ->view('site::email.user.repair.status');
    }
}
