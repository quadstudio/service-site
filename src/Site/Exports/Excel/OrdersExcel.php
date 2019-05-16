<?php

namespace QuadStudio\Service\Site\Exports\Excel;

use QuadStudio\Service\Site\Models\Message;
use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Models\OrderItem;
use QuadStudio\Service\Site\Support\Excel;

class OrdersExcel extends Excel
{
    /** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet Sheet */
    private $_sheet;




    function build()
    {
        if (is_null($this->repository)) {
            echo "Невозможно создать xls файл, т.к. не указан репозиторий с данными";
            exit();
        }
        $this->getProperties()->setTitle(trans('site::order.orders'));
        $this->getActiveSheet()->setTitle(trans('site::order.orders'));
        $this->_sheet = $this->getActiveSheet();
        
		$count = 1;
        foreach (trans('site::order.excelm') as $cell => $value) {
            $this->_sheet->setCellValue($cell . $count, $value);
        }
		
		$this->_sheet->getColumnDimension('A')->setWidth(5);
        $this->_sheet->getColumnDimension('B')->setAutoSize(true);
        $this->_sheet->getColumnDimension('C')->setAutoSize(true);
        $this->_sheet->getColumnDimension('D')->setAutoSize(true);
        $this->_sheet->getColumnDimension('E')->setAutoSize(true);
        $this->_sheet->getColumnDimension('F')->setAutoSize(true);
        $this->_sheet->getColumnDimension('G')->setAutoSize(true);
        $this->_sheet->getColumnDimension('H')->setAutoSize(true);
		
        /**
         * @var int $key
         * @var Order $order
         */
        foreach ($this->repository->all() as $key => $order) {
			$count++;
            $this->_buildOrder($order, $count);
            
        }

    }

    private function _buildOrder(Order $order, $count)
    {
        $this->_sheet
            ->setCellValue('A' . $count, $count - 1);
		$this->_sheet
            ->setCellValue('B' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($order->getAttribute('created_at')))
            ->getStyle('B' . $count)
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
		$this->_sheet
            ->setCellValue('C' . $count, $order->getAttribute('id'))
            ->setCellValue('D' . $count, $order->address->name)
			->setCellValue('E' . $count, $order->contragent->name)
            ->setCellValue('F' . $count, $order->user->name)
			->setCellValue('G' . $count, $order->total())
			->setCellValue('H' . $count, $order->status->name)
			->setCellValue('I' . $count, $order->contacts_comment);
    }
}