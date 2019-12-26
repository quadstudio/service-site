<?php

namespace QuadStudio\Service\Site\Mail\User\Repair;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Repair;

class RepairStatusEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Repair
     */
    public $repair;
    /**
     * @var string
     */
    public $adminMessage;

    /**
     * Create a new message instance.
     * @param Repair $repair
     * @param null $adminMessage
     */
    public function __construct(Repair $repair, $adminMessage = null)
    {
        $this->repair = $repair;
        $this->adminMessage = $adminMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Уведомление от service.ferroli.ru')
            ->view('site::email.user.repair.status')->with('adminMessage', $this->adminMessage);
    }
}
