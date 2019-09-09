<?php

namespace QuadStudio\Service\Site\Imports\Url;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class StorehouseExcelLoadFilter implements IReadFilter
{
    public function readCell($column, $row, $worksheetName = '')
    {

        if ($row >= 1 && $row <= config('site.storehouse_product_limit', 300)) {
            if (in_array($column, range('A', 'B'))) {
                return true;
            }
        }
        return false;
    }

}