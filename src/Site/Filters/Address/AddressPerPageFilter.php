<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Filters\PerPageFilter;

class AddressPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.address', 10)];
    }
}