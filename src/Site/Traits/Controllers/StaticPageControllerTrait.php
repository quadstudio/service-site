<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Events\FeedbackCreateEvent;
use QuadStudio\Service\Site\Filters\User\ActiveFilter;
use QuadStudio\Service\Site\Filters\User\DisplayFilter;
use QuadStudio\Service\Site\Filters\User\IsDealerFilter;
use QuadStudio\Service\Site\Filters\User\IsServiceFilter;
use QuadStudio\Service\Site\Filters\User\SortByRegionFilter;
use QuadStudio\Service\Site\Filters\User\WithAddressesFilter;
use QuadStudio\Service\Site\Filters\User\WithPhonesFilter;
use QuadStudio\Service\Site\Http\Requests\FeedbackRequest;
use QuadStudio\Service\Site\Repositories\UserRepository;

trait StaticPageControllerTrait
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

//    /**
//     * Show application index page
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function whereToBuy()
//    {
//        $this->users->trackFilter();
//        $users = $this->users
//            ->applyFilter(new AddressActiveFilter())
//            ->applyFilter(new DisplayFilter())
//            ->applyFilter(new IsDealerFilter())
//            ->applyFilter(new IsServiceFilter())
//            ->applyFilter(new WithPhonesFilter())
//            ->applyFilter(new WithAddressesFilter())
//            ->pushTrackFilter(SortByRegionFilter::class)
//            ->all(['users.*']);
//
//        return view('site::static.where_to_buy', compact('users'));
//    }

}
