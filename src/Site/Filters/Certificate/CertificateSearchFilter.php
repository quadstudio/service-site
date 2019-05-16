<?php

namespace QuadStudio\Service\Site\Filters\Certificate;

use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class CertificateSearchFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_serial';

    public function label()
    {
        return trans('site::certificate.placeholder.search');
    }

    protected function columns()
    {
        return [
            'certificates.id',
            'certificates.name',
            'certificates.organization',
        ];
    }

    protected function attributes()
    {
        $attributes = parent::attributes();
        $attributes->put('style', 'min-width: 208px;');

        return $attributes;
    }
}