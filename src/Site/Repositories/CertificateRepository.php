<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Certificate\CertificateSearchFilter;
use QuadStudio\Service\Site\Filters\Certificate\CertificateTypeSelectFilter;
use QuadStudio\Service\Site\Models\Certificate;

class CertificateRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Certificate::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            CertificateSearchFilter::class,
            CertificateTypeSelectFilter::class,
        ];
    }
}