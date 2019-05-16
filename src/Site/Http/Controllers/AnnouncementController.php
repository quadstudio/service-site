<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Announcement\PublishedFilter;
use QuadStudio\Service\Site\Filters\Announcement\SortDateFilter;
use QuadStudio\Service\Site\Repositories\AnnouncementRepository;

class AnnouncementController extends Controller
{

    protected $announcements;

    /**
     * Create a new controller instance.
     *
     * @param AnnouncementRepository $announcements
     */
    public function __construct(AnnouncementRepository $announcements)
    {
        $this->announcements = $announcements;
    }

    /**
     * Show the announcements index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->announcements->trackFilter();
        $this->announcements->applyFilter(new PublishedFilter());
        $this->announcements->applyFilter(new SortDateFilter());

        return view('site::announcement.index', [
            'repository'    => $this->announcements,
            'announcements' => $this->announcements->paginate(config('site.per_page.announcement', 10), ['announcements.*'])
        ]);
    }

}