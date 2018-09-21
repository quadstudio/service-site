<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use QuadStudio\Service\Site\Filters\Message\ScSearchFilter;
use QuadStudio\Service\Site\Filters\Message\SortFilter;
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
        $this->messages->applyFilter(new SortFilter());
        $this->messages->pushTrackFilter( ScSearchFilter::class);
        return view('site::admin.message.index', [
            'repository' => $this->messages,
            'messages'      => $this->messages->paginate(config('site.per_page.message', 30), ['messages.*'])
        ]);
    }

    public function show(Message $message)
    {
        return view('site::admin.message.show', compact('message'));
    }
}