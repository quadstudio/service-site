<?php

namespace QuadStudio\Service\Site\Support;

class CertificateLoadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    public function readCell($column, $row, $worksheetName = '') {
        //  Read rows 1 to 300 and columns A to C only
        if ($row >= 1 && $row <= 300) {
            if (in_array($column,range('A','C'))) {
                return true;
            }
        }
        return false;
    }

}