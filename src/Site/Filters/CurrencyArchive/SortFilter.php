<?php

namespace QuadStudio\Service\Site\Filters\CurrencyArchive;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'currency_archives.date' => 'DESC'
        ];
    }

}