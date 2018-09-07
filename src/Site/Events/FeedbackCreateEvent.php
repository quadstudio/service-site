<?php

namespace QuadStudio\Service\Site\Events;

use Illuminate\Queue\SerializesModels;

class FeedbackCreateEvent
{
    use SerializesModels;

    /**
     * Данные сообщения
     *
     * @var array
     */
    public $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
