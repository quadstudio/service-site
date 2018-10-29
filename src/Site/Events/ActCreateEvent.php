<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use QuadStudio\Service\Site\Models\User;

class ActCreateEvent
{
    use SerializesModels;

    /**
     * Заказ
     *
     * @var User
     */
    public $user;
    /**
     * @var Collection
     */
    public $acts;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Collection $acts
     */
    public function __construct(User $user, Collection $acts)
    {
        $this->user = $user;
        $this->acts = $acts;
    }
}
