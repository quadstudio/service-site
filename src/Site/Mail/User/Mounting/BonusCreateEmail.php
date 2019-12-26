<?php

namespace QuadStudio\Service\Site\Mail\User\Mounting;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Mounting;

class BonusCreateEmail extends Mailable implements ShouldQueue
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
            ->subject(trans('site::mounting.email.bonus_create.title'))
            ->view('site::email.admin.mounting.bonus_create');
    }
}
