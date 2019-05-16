<?php

namespace QuadStudio\Service\Site\Filters\Contact;

use QuadStudio\Repo\Filters\PerPageFilter;

class ContactPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.contact', 10)];
    }
}