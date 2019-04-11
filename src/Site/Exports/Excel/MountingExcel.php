<?php

namespace QuadStudio\Service\Site\Exports\Excel;

use QuadStudio\Service\Site\Models\Mounting;
use QuadStudio\Service\Site\Support\Excel;

class MountingExcel extends Excel
{
    /** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet Sheet */
    private $_sheet;


    function build()
    {
        if (is_null($this->repository)) {
            echo "Невозможно создать xls файл, т.к. не указан репозиторий с данными";
            exit();
        }
        $this->getProperties()->setTitle(trans('site::mounting.mountings'));
        $this->getActiveSheet()->setTitle(trans('site::mounting.mountings'));
        $this->_sheet = $this->getActiveSheet();
        $count = 1;
        foreach (trans('site::mounting.excel') as $cell => $value) {
            $this->_sheet->setCellValue($cell . $count, $value);
        }

        /**
         * @var int $key
         * @var Mounting $mounting
         */
        foreach ($this->repository->all() as $key => $mounting) {
            $count++;
            $this->_buildMounting($mounting, $count);

        }

    }

    private function _buildMounting(Mounting $mounting, $count)
    {
        $this->_sheet
            ->setCellValue('A' . $count, $count - 1)
            ->setCellValue('B' . $count, $mounting->status->getAttribute('name'))
            ->setCellValue('C' . $count, $mounting->getAttribute('id'));
        $this->_sheet
            ->setCellValue('D' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($mounting->getAttribute('created_at')))
            ->getStyle('D' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
        if ($mounting->act()->exists()) {
            $this->_sheet->setCellValue('E' . $count, $mounting->act->getAttribute('number'));
            $this->_sheet->setCellValue('F' . $count, trans('site::messages.' . ($mounting->act->getAttribute('received') == 1 ? 'yes' : 'no')));
            $this->_sheet->setCellValue('G' . $count, trans('site::messages.' . ($mounting->act->getAttribute('paid') == 1 ? 'yes' : 'no')));
        }
        if ($mounting->contragent()->exists()) {
            $this->_sheet->setCellValue('H' . $count, $mounting->contragent->getAttribute('name'));
            /** @var \Illuminate\Database\Eloquent\Relations\MorphMany $addresses */
            if (($addresses = $mounting->contragent->addresses()->where('type_id', 1))->exists()) {
                $this->_sheet->setCellValue('I' . $count, $addresses->first()->getAttribute('locality'));
            }
        }
        $this->_sheet
            ->setCellValue('J' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($mounting->getAttribute('date_mounting')))
            ->getStyle('J' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
        $this->_sheet
            ->setCellValue('K' . $count, $mounting->getAttribute('serial_id'))
            ->setCellValue('L' . $count, $mounting->product->getAttribute('name'))
            ->setCellValue('M' . $count, $mounting->product->getAttribute('sku'))
            ->setCellValue('N' . $count, $mounting->getAttribute('bonus'))
            ->setCellValue('O' . $count, $mounting->getAttribute('enabled_social_bonus'))
            ->setCellValue('P' . $count, $mounting->getAttribute('total'))
            ->setCellValue('Q' . $count, $mounting->source_id != 4 ? $mounting->source->name : $mounting->source_other)
            ->setCellValue('R' . $count, $mounting->getAttribute('social_url'))
            ->setCellValue('S' . $count, $mounting->getAttribute('client'))
            ->setCellValue('T' . $count, $mounting->getAttribute('address'))
            ->setCellValue('U' . $count, $mounting->country->getAttribute('phone') . $mounting->getAttribute('phone_primary'))
            ->setCellValue('V' . $count, $mounting->trade->getAttribute('name'));
        $this->_sheet
            ->setCellValue('W' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($mounting->getAttribute('date_trade')))
            ->getStyle('W' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
    }
}
