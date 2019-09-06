<?php

namespace QuadStudio\Service\Site\Mail\Storehouse;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Models\StorehouseLog;

class UserStorehouseLogCreateEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

	/**
	 * @var StorehouseLog
	 */
	public $storehouseLog;

	/**
	 * Create a new message instance.
	 *
	 * @param StorehouseLog $storehouseLog
	 */
    public function __construct(StorehouseLog $storehouseLog)
    {
	    $this->storehouseLog = $storehouseLog;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(trans('site::storehouse_log.email.create.title'))
            ->view('site::email.storehouse_log.user.create');
    }
}
