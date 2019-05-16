<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Events\FeedbackCreateEvent;
use QuadStudio\Service\Site\Http\Requests\FeedbackRequest;
use QuadStudio\Service\Site\Repositories\UserRepository;

class StaticPageController extends Controller
{
    private $users;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Show application index page
     *
     * @return \Illuminate\Http\Response
     */
    public function abouts()
    {
        return view('site::static.abouts');
    }

    /**
     * Show application index page
     *
     * @return \Illuminate\Http\Response
     */
    public function feedback()
    {
        return view('site::static.feedback');
    }

    public function message(FeedbackRequest $request)
    {
        event(new FeedbackCreateEvent($request->only(['name', 'email', 'message'])));

        return redirect()->route('feedback')->with('success', trans('Сообщение отправлено'));
    }

}
