<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

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
        return view('site::message.index', [
            'repository' => $this->messages,
            'items'      => $this->messages->paginate(config('site.per_page.message', 10), [env('DB_PREFIX', '').'messages.*'])
        ]);
    }

    public function show(Message $message)
    {
        return view('site::message.show', ['message' => $message]);
    }
}