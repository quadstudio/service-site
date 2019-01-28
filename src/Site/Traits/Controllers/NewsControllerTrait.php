<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\News\PublishedFilter;
use QuadStudio\Service\Site\Filters\News\SortDateFilter;
use QuadStudio\Service\Site\Repositories\NewsRepository;

trait NewsControllerTrait
{

    protected $news;

    /**
     * Create a new controller instance.
     *
     * @param NewsRepository $news
     */
    public function __construct(NewsRepository $news)
    {
        $this->news = $news;
    }

    /**
     * Show the news index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->news->trackFilter();
        $this->news->applyFilter(new PublishedFilter());
        $this->news->applyFilter(new SortDateFilter());
        return view('site::news.index', [
            'repository' => $this->news,
            'news'       => $this->news->paginate(config('site.per_page.news', 15), ['news.*'])
        ]);
    }

}