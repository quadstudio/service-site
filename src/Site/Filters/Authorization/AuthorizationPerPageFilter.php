<?php

namespace QuadStudio\Service\Site\Filters\Authorization;

use QuadStudio\Repo\Filters\PerPageFilter;

class AuthorizationPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.authorization', 10)];
    }
}