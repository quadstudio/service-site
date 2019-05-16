<?php

namespace QuadStudio\Service\Site\Filters\Certificate;

use QuadStudio\Repo\Filters\PerPageFilter;

class CertificatePerPageFilter extends PerPageFilter
{
    public function defaults(): array
    {
        return [config('site.per_page.certificate', 10)];
    }
}