<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Filters\BootstrapDate;
use QuadStudio\Repo\Filters\DateFilter;

class DateNewsToFilter extends DateFilter
{

    use BootstrapDate;

    protected $render = true;
    protected $search = 'date_news_to';

    public function label()
    {
        return trans('site::news.placeholder.date_news_to');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'news.date';
    }

    protected function operator()
    {
        return '<=';
    }


}