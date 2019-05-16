<?php

namespace QuadStudio\Service\Site\Filters\Announcement;

use QuadStudio\Repo\Filters\PerPageFilter;

class AnnouncementPerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.announcement', 10)];
    }
}