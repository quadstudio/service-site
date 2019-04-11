<?php

namespace QuadStudio\Service\Site\Exports\Excel;

use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Support\Excel;

class ContragentExcel extends Excel
{
    /** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet Sheet */
    private $_sheet;


    function build()
    {
        if (is_null($this->repository)) {
            echo "Невозможно создать xls файл, т.к. не указан репозиторий с данными";
            exit();
        }
        $count = 1;
        $this->getProperties()->setTitle(trans('site::contragent.contragents'));
        $this->getActiveSheet()->setTitle(trans('site::contragent.contragents'));
        $this->_sheet = $this->getActiveSheet();
        foreach (trans('site::contragent.excel') as $cell => $value) {
            $this->_sheet->setCellValue($cell . $count, $value);
        }

        /**
         * @var int $key
         * @var Contragent $contragent
         */
        foreach ($this->repository->all() as $key => $contragent) {
            $count++;
            $this->_buildContragent($contragent, $count);

        }

    }

    private function _buildContragent(Contragent $contragent, $count)
    {
        $this->_sheet
            ->setCellValue('A' . $count, $count - 1)
            ->setCellValue('B' . $count, $contragent->getAttribute('name'))
            ->setCellValue('C' . $count, $contragent->type->getAttribute('name'))
            ->setCellValue('D' . $count, $contragent->organization->getAttribute('guid'))
            ->setCellValue('E' . $count, $contragent->getAttribute('contract'))
            ->setCellValue('F' . $count, $contragent->getAttribute('guid'));
        $this->_sheet
            ->setCellValue('G' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($contragent->getAttribute('created_at')))
            ->getStyle('G' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
        $this->_sheet
            ->setCellValue('H' . $count, $contragent->user->getAttribute('name'));
    }
}
