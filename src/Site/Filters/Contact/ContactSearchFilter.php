<?php

namespace QuadStudio\Service\Site\Filters\Contact;

use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class ContactSearchFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search';

    protected function columns()
    {
        return [
            'contacts.name',
            'contacts.position',
        ];
    }

    public function label()
    {
        return trans('site::contact.placeholder.search');
    }

    public function tooltip()
    {
        return trans('site::contact.help.search');
    }

}