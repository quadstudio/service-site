<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\Message\BelongsScFilter;
use QuadStudio\Service\Site\Repositories\MessageRepository;
use QuadStudio\Service\Site\Models\Message;

trait MessageControllerTrait
{

    protected $messages;

    /**
     * Create a new controller instance.
     *
     * @param MessageRepository $messages
     */
    public function __construct(MessageRepository $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->messages->trackFilter();
        $this->messages->pushTrackFilter(BelongsScFilter::class);
        return view('site::message.index', [
            'repository' => $this->messages,
            'messages'      => $this->messages->paginate(config('site.per_page.message', 10), ['messages.*'])
        ]);
    }

    public function show(Message $message)
    {
        return view('site::message.show', ['message' => $message]);
    }
}