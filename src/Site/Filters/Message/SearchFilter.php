<?php

namespace QuadStudio\Service\Site\Filters\Message;

use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class SearchFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_message';

    protected function columns()
    {
        return [
            env('DB_PREFIX', '') . 'messages.text',
        ];
    }

    public function label()
    {
        return trans('site::message.placeholder.search_text');
    }

    public function tooltip()
    {
        return trans('site::message.help.search_text');
    }

}