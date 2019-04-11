<?php

namespace QuadStudio\Service\Site\Filters\Message;

use QuadStudio\Repo\Filters\PerPageFilter;

class MessagePerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.message', 25)];
    }
}