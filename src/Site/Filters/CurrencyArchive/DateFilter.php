<?php

namespace QuadStudio\Service\Site\Filters\CurrencyArchive;

use QuadStudio\Repo\Filters\BootstrapDate;
use QuadStudio\Repo\Filters\DateFilter as BaseFilter;

class DateFilter extends BaseFilter
{

    use BootstrapDate;

    protected $render = true;
    protected $search = 'search_date';


    public function label()
    {
        return trans('site::archive.placeholder.date');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'currency_archives.date';
    }


}