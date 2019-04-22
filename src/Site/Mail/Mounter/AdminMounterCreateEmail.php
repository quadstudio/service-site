<?php

namespace QuadStudio\Service\Site\Mail\Mounter;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Mounter;

class AdminMounterCreateEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Mounter
     */
    public $mounter;

    /**
     * Create a new message instance.
     * @param Mounter $mounter
     */
    public function __construct(Mounter $mounter)
    {
        $this->mounter = $mounter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(trans('site::mounter.email.create.title'))
            ->view('site::email.mounter.admin.create');
    }
}
