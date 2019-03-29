<?php

namespace QuadStudio\Service\Site\Mail\Admin\Authorization;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Authorization;
use QuadStudio\Service\Site\Models\Order;

class AuthorizationCreateEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Authorization
     */
    public $authorization;

    /**
     * Create a new message instance.
     * @param Authorization $authorization
     */
    public function __construct(Authorization $authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(trans('site::authorization.email.title'))
            ->view('site::email.admin.authorization.create');
    }
}
