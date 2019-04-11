<?php

namespace QuadStudio\Service\Site\Mail\User\Act;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use QuadStudio\Service\Site\Models\User;

class AdminActMountingCreateEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    public $user;

    /**
     * @var Collection
     */
    public $acts;

    /**
     * Create a new message instance.
     * @param User $user
     * @param Collection $acts
     */
    public function __construct(User $user, Collection $acts)
    {
        $this->user = $user;
        $this->acts = $acts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(trans('site::act.email.create.mounting.title'))
            ->view('site::email.act.mounting.admin.create');
    }
}
