<?php

namespace QuadStudio\Service\Site\Exports\Excel;

use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Support\Excel;

class AddressExcel extends Excel
{
    /** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet Sheet */
    private $_sheet;


    function build()
    {
        if (is_null($this->repository)) {
            echo "Невозможно создать xls файл, т.к. не указан репозиторий с данными";
            exit();
        }
        $this->getProperties()->setTitle(trans('site::address.addresses'));
        $this->getActiveSheet()->setTitle(trans('site::address.addresses'));
        $this->_sheet = $this->getActiveSheet();
        $count = 1;
        foreach (trans('site::address.excel') as $cell => $value) {
            $this->_sheet->setCellValue($cell . $count, $value);
        }

        /**
         * @var int $key
         * @var Address $address
         */
        foreach ($this->repository->all() as $key => $address) {
            $count++;
            $this->_build($address, $count);
        }

    }

    private function _build(Address $address, $count)
    {
        $this->_sheet
            ->setCellValue('A' . $count, $count - 1)
            ->setCellValue('B' . $count, $address->country->getAttribute('name'))
            ->setCellValue('C' . $count, $address->region->getAttribute('name'))
            ->setCellValue('D' . $count, $address->getAttribute('locality'))
            ->setCellValue('E' . $count, $address->getAttribute('street'))
            ->setCellValue('F' . $count, $address->getAttribute('building'));
    }
}
