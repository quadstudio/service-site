<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Filters\PerPageFilter;

class MemberPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.member', 10)];
    }
}