<?php

namespace QuadStudio\Service\Site\Filters\Catalog;

use QuadStudio\Repo\Filters\PerPageFilter;

class CatalogPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.catalog', 25)];
    }
}