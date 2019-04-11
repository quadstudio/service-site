<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Message\MessagePerPageFilter;
use QuadStudio\Service\Site\Filters\Message\ScSearchFilter;
use QuadStudio\Service\Site\Filters\Message\SortFilter;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Repositories\MessageRepository;
use QuadStudio\Service\Site\Models\Message;

class MessageController extends Controller
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
     * @param MessageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(MessageRequest $request)
    {

        $this->messages->trackFilter();
        $this->messages->applyFilter(new SortFilter());
        $this->messages->pushTrackFilter( ScSearchFilter::class);
        $this->messages->pushTrackFilter(MessagePerPageFilter::class);
        return view('site::admin.message.index', [
            'repository' => $this->messages,
            'messages'      => $this->messages->paginate($request->input('filter.per_page', config('site.per_page.message', 25)), ['messages.*'])
        ]);
    }

    public function show(Message $message)
    {
        return view('site::admin.message.show', compact('message'));
    }
}