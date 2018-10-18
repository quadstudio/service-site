<?php

namespace QuadStudio\Service\Site\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use QuadStudio\Service\Site\Models\Page;

class PageViewComposer
{
    public function compose(View $view)
    {

        $page_title = null;
        $page_description = null;
        $page_h1 = null;
        if (($page = Page::query()->where('route', request()->route()->getName()))->exists()) {
            $page_title = $page->first()->name;
            $page_description = $page->first()->description;
            $page_h1 = $page->first()->h1;
        }
        $view->with('page_title', $page_title);
        $view->with('page_description', $page_description);
        $view->with('page_h1', $page_h1);
    }
}