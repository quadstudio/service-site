<?php

namespace QuadStudio\Service\Site\Exports\Excel;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\Repair;
use QuadStudio\Service\Site\Support\Excel;


class RepairExcel extends Excel
{
    /** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet Sheet */
    private $_sheet;

    function build(Repository $repository)
    {
        $this->_sheet = $this->getActiveSheet();
        foreach (trans('site::repair.excel') as $cell => $value) {
            $this->_sheet->setCellValue($cell, $value);
        }
        $count = 2;
        /**
         * @var int $key
         * @var Repair $repair
         */
        foreach ($repository->all() as $key => $repair) {

            $this->_buildRepair($repair, $count);
            /** @var \Illuminate\Database\Eloquent\Relations\MorphMany $parts */
            if (($parts = $repair->parts())->exists()) {
                /** @var int $k */
                foreach ($parts->get() as $k => $part) {
                    if ($k > 0) {
                        $count++;
                        $this->_buildRepair($repair, $count);
                    }
                    $this->_sheet
                        ->setCellValue('R' . $count, $part->product->getAttribute('sku'))
                        ->setCellValue('S' . $count, $part->product->getAttribute('name'));
                }
            }
            $count++;
            //dd($repair);
        }

    }

    private function _buildRepair(Repair $repair, $count)
    {
        $this->_sheet
            ->setCellValue('A' . $count, $count - 1)
            ->setCellValue('B' . $count, $repair->status->getAttribute('name'))
            ->setCellValue('C' . $count, $repair->getAttribute('id'));
        $this->_sheet
            ->setCellValue('D' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($repair->getAttribute('created_at')))
            ->getStyle('D' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
        if ($repair->act()->exists()) {
            $this->_sheet->setCellValue('E' . $count, $repair->act->getAttribute('number'));
        }
        if ($repair->contragent()->exists()) {
            $this->_sheet->setCellValue('F' . $count, $repair->contragent->getAttribute('name'));
            /** @var \Illuminate\Database\Eloquent\Relations\MorphMany $addresses */
            if (($addresses = $repair->contragent->addresses()->where('type_id', 1))->exists()) {
                $this->_sheet->setCellValue('G' . $count, $addresses->first()->getAttribute('locality'));
            }
        }
        $this->_sheet
            ->setCellValue('H' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($repair->getAttribute('date_repair')))
            ->getStyle('H' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
        $this->_sheet
            ->setCellValue('I' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($repair->getAttribute('date_launch')))
            ->getStyle('I' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
        $this->_sheet
            ->setCellValue('J' . $count, $repair->getAttribute('serial_id'))
            ->setCellValue('K' . $count, $repair->product->getAttribute('name'))
            ->setCellValue('L' . $count, $repair->product->getAttribute('sku'))
            ->setCellValue('M' . $count, $repair->distance->getAttribute('name'))
            ->setCellValue('N' . $count, $repair->cost_distance())
            ->setCellValue('O' . $count, $repair->cost_difficulty())
            ->setCellValue('P' . $count, $repair->cost_parts())
            ->setCellValue('Q' . $count, $repair->getAttribute('TotalCostPartsEuro'))
            ->setCellValue('T' . $count, $repair->getAttribute('TotalCost'))
            ->setCellValue('U' . $count, $repair->getAttribute('client'))
            ->setCellValue('V' . $count, $repair->getAttribute('address'))
            ->setCellValue('W' . $count, $repair->country->getAttribute('phone') . $repair->getAttribute('phone_primary'))
            ->setCellValue('X' . $count, $repair->trade->getAttribute('name'));
        $this->_sheet
            ->setCellValue('Y' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($repair->getAttribute('date_trade')))
            ->getStyle('Y' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');

        $this->_sheet->setCellValue('Z' . $count, $repair->launch->getAttribute('name'));

        $this->_sheet
            ->setCellValue('AA' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($repair->getAttribute('date_launch')))
            ->getStyle('AA' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
        $this->_sheet
            ->setCellValue('AB' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($repair->getAttribute('date_call')))
            ->getStyle('AB' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
        $this->_sheet
            ->setCellValue('AC' . $count, $repair->getAttribute('reason_call'))
            ->setCellValue('AD' . $count, $repair->getAttribute('diagnostics'))
            ->setCellValue('AE' . $count, $repair->getAttribute('works'));
    }
}