<?php

namespace QuadStudio\Service\Site\Filters\CurrencyArchive;

use QuadStudio\Repo\Filters\PerPageFilter;

class CurrencyArchivePerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.archive', 25)];
    }
}