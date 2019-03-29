<?php

namespace QuadStudio\Service\Site\Mail\User\Mounting;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Mounting;

class MountingStatusChangeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Mounting
     */
    public $mounting;

    /**
     * Create a new message instance.
     * @param Mounting $mounting
     */
    public function __construct(Mounting $mounting)
    {
        $this->mounting = $mounting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(trans('site::mounting.email.status_change.title'))
            ->view('site::email.user.mounting.status_change');
    }
}
