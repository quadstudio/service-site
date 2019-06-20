<?php

namespace QuadStudio\Service\Site\Exports\Excel;

use QuadStudio\Service\Site\Models\Repair;
use QuadStudio\Service\Site\Support\Excel;

class RepairExcel extends Excel
{
    /** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet Sheet */
    private $_sheet;
	
	
	
	
    function build()
    {
        if (is_null($this->repository)) {
            echo "Невозможно создать xls файл, т.к. не указан репозиторий с данными";
            exit();
        }
        $this->_sheet = $this->getActiveSheet();
        foreach (trans('site::repair.excel') as $cell => $value) {
            $this->_sheet->setCellValue($cell, $value)->getStyle($cell)->getFont($cell)->setBold(true);
        }
    $count = 2;
	$second = 0;
        $this->_sheet->getColumnDimension('A')->setWidth(5);
        $this->_sheet->getColumnDimension('B')->setWidth(20);
        $this->_sheet->getColumnDimension('C')->setAutoSize(true);
        $this->_sheet->getColumnDimension('D')->setAutoSize(true);
        $this->_sheet->getColumnDimension('E')->setAutoSize(true);
        $this->_sheet->getColumnDimension('F')->setAutoSize(true);
        $this->_sheet->getColumnDimension('G')->setWidth(30);
        $this->_sheet->getColumnDimension('H')->setWidth(30);
        $this->_sheet->getColumnDimension('I')->setWidth(15);
        $this->_sheet->getColumnDimension('J')->setAutoSize(true);
        $this->_sheet->getColumnDimension('K')->setAutoSize(true);
        $this->_sheet->getColumnDimension('L')->setAutoSize(true);
        $this->_sheet->getColumnDimension('M')->setAutoSize(true);
        $this->_sheet->getColumnDimension('N')->setAutoSize(true);
        $this->_sheet->getColumnDimension('O')->setAutoSize(true);
        $this->_sheet->getColumnDimension('P')->setAutoSize(true);
        $this->_sheet->getColumnDimension('Q')->setAutoSize(true);
        $this->_sheet->getColumnDimension('R')->setAutoSize(true);
        $this->_sheet->getColumnDimension('S')->setAutoSize(true);
        $this->_sheet->getColumnDimension('T')->setAutoSize(true);
        $this->_sheet->getColumnDimension('U')->setAutoSize(true);
        $this->_sheet->getColumnDimension('V')->setAutoSize(true);
        $this->_sheet->getColumnDimension('W')->setAutoSize(true);
        $this->_sheet->getColumnDimension('X')->setWidth(10);
        $this->_sheet->getColumnDimension('Y')->setWidth(15);
        $this->_sheet->getColumnDimension('Z')->setWidth(30);
        $this->_sheet->getColumnDimension('AA')->setWidth(30);
        foreach ($this->repository->all() as $key => $repair) {
            $this->_buildRepair($repair, $count);
           
            if (($parts = $repair->parts())->exists()) {
				$second = 0;
                foreach ($parts->get() as $k => $part) {
                    if ($k > 0) {
                        $count++;
                       if ($second = 0) { $this->_buildRepair($repair, $count); }	
                    }
            $this->_sheet->setCellValue('A' . $count, $count - 1)->getStyle('A' . $count)->getAlignment()->setHorizontal('left');
			if ($repair->act()->exists()) {
            $this->_sheet->setCellValue('B' . $count, $repair->act->getAttribute('number'));
            }
			
			$this->_sheet
				->setCellValue('J' . $count, $part->product->getAttribute('name'))
				->setCellValue('K' . $count, $part->product->getAttribute('RepairPrice')->price *  $part->getAttribute('count'))
                ->setCellValue('L' . $count, $part->product->getAttribute('sku'))
				->setCellValue('Y' . $count, $part->cost() *  $part->getAttribute('count'));
				$second++;
                }
            }
            $count++;
            
        }

    }

    private function _buildRepair(Repair $repair, $count)
    {	$this->_sheet
			->setCellValue('A' . $count, $count - 1)->getStyle('A' . $count)->getAlignment()->setHorizontal('left');
		if ($repair->act()->exists()) {
		$this->_sheet
			->setCellValue('B' . $count, $repair->act->getAttribute('number'));
		}
        $this->_sheet
			->setCellValue('C' . $count, $repair->product->getAttribute('name'))
            ->setCellValue('D' . $count, $repair->getAttribute('serial_id'));
			
		$this->_sheet
            ->setCellValue('E' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($repair->getAttribute('date_trade')))
            ->getStyle('E' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
			$this->_sheet->getStyle('E' . $count)->getAlignment()->setHorizontal('center');
		$this->_sheet
            ->setCellValue('F' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($repair->getAttribute('date_launch')))
            ->getStyle('F' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
			$this->_sheet->getStyle('F' . $count)->getAlignment()->setHorizontal('center');
		$this->_sheet
			->setCellValue('G' . $count, $repair->getAttribute('address'));
		
		$this->_sheet
			->setCellValue('H' . $count, $repair->getAttribute('client'))
			->setCellValue('I' . $count, "'" . $repair->country->getAttribute('phone') . $repair->getAttribute('phone_primary'));
		
		$this->_sheet	
            ->setCellValue('M' . $count, $repair->cost_difficulty())
			->setCellValue('N' . $count, $repair->cost_distance());
			
		$this->_sheet
            ->setCellValue('O' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($repair->getAttribute('date_repair')))
            ->getStyle('O' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
		$this->_sheet	
			->setCellValue('P' . $count, $repair->getAttribute('TotalCost'));
			
			
        if ($repair->contragent()->exists()) {
            $this->_sheet->setCellValue('Q' . $count, $repair->contragent->getAttribute('name'));
            if (($addresses = $repair->contragent->addresses()->where('type_id', 1))->exists()) {
                $this->_sheet->setCellValue('R' . $count, $addresses->first()->getAttribute('locality'));
            }
        }
		$this->_sheet
			->setCellValue('S' . $count, $repair->getAttribute('id'));
        $this->_sheet
            ->setCellValue('T' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($repair->getAttribute('created_at')))
            ->getStyle('T' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
		$this->_sheet
			->setCellValue('U' . $count, $repair->status->getAttribute('name'));
       
	   if ($repair->act()->exists()) {
            if ($repair->act->getAttribute('received')) 
				$this->_sheet->setCellValue('V' . $count, "ДА");
			else $this->_sheet->setCellValue('V' . $count, "НЕТ");
        }
		
		$this->_sheet
			->setCellValue('W' . $count, $repair->product->getAttribute('sku'))
            ->setCellValue('X' . $count, $repair->distance->getAttribute('name'))
			
			
			->setCellValue('AB' . $count, $repair->getAttribute('reason_call'))
            ->setCellValue('AC' . $count, $repair->getAttribute('diagnostics'))
            ->setCellValue('AD' . $count, $repair->getAttribute('works'));
			
    }
}
