<?php

namespace QuadStudio\Service\Site\Exports\Excel;

use QuadStudio\Service\Site\Models\Message;
use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Models\OrderItem;
use QuadStudio\Service\Site\Support\Excel;

class StorehouseExcel extends Excel
{
    /** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet Sheet */
    private $_sheet;


    function build()
    {
        if (is_null($this->model)) {
            echo "Невозможно создать xls файл, т.к. не указана модель с данными";
            exit();
        }
        /** @var Order $order */
        $order = $this->model;
        $this->getProperties()->setTitle(trans('site::order.distributor'));


        $this->_sheet = $this->getActiveSheet();
        $this->_sheet->setTitle(trans('site::order.distributor'));
        $this->_sheet->getStyle('B8')->getAlignment()->setWrapText(true);

        foreach (trans('site::order.excel') as $cell => $value) {
            $this->_sheet->setCellValue($cell, $value);
        }

        $this->_sheet
            ->setCellValue('B2', \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($order->getAttribute('created_at')))
            ->getStyle('B2')
            ->getNumberFormat()
            ->setFormatCode('dd.mm.yyyy');
        $this->_sheet
            ->setCellValue('B1', $order->getAttribute('id'))
            ->setCellValue('B3', $order->contragent->name)
            ->setCellValue('B4', $order->user->name)
            ->setCellValue('B5', $order->user->email)
            ->setCellValue('B6', $order->contacts_comment)
            ->setCellValue('B7', $order->address->name)
            ->setCellValue('B8', $order->messages->implode('text', "\n\n"));
        /** @var Message $message */


        $count = 11;
        /**
         * @var int $key
         * @var OrderItem $item
         */
        foreach ($order->items as $key => $item) {

            $this->_buildOrder($item, $count);

        }

        $this->_sheet->getColumnDimension('A')->setAutoSize(true);
        $this->_sheet->getColumnDimension('B')->setWidth(30);
        $this->_sheet->getColumnDimension('C')->setAutoSize(true);
        $this->_sheet->getColumnDimension('D')->setAutoSize(true);
        $this->_sheet->getColumnDimension('E')->setAutoSize(true);
        $this->_sheet->getColumnDimension('F')->setAutoSize(true);

    }

    private function _buildOrder(OrderItem $item, &$count)
    {
        $this->_sheet
            ->setCellValue('A' . $count, $item->product->name)
            ->setCellValue('B' . $count, $item->product->sku)
            ->setCellValue('C' . $count, $item->quantity)
            ->setCellValue('D' . $count, $item->product->unit)
            ->setCellValue('E' . $count, $item->price > 0 ? $item->price : trans('site::price.help.price'))
            ->setCellValue('F' . $count, $item->subtotal() > 0 ? $item->subtotal() : trans('site::price.help.price'));
        $count++;
    }
}
