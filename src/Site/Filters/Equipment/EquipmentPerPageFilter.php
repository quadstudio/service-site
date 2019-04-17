<?php

namespace QuadStudio\Service\Site\Filters\Equipment;

use QuadStudio\Repo\Filters\PerPageFilter;

class EquipmentPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.equipment', 10)];
    }
}