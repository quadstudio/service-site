<?php

namespace QuadStudio\Service\Site\Filters\MountingBonus;

use QuadStudio\Repo\Filters\PerPageFilter;

class MountingBonusPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.mounting_bonus', 10)];
    }
}