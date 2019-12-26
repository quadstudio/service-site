<?php

namespace QuadStudio\Service\Site\Exports\Excel;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use QuadStudio\Service\Site\Models\Storehouse;
use QuadStudio\Service\Site\Models\StorehouseProduct;

class StorehouseExcelUser extends StorehouseExcel
{

	/**
	 * @throws \PhpOffice\PhpSpreadsheet\Exception
	 */
	function build()
	{
		parent::build();

		$count = 1;

		foreach (trans('site::storehouse.excel.user') as $cell => $value) {
			$this->_sheet->setCellValue($cell . $count, $value);
		}

		/**
		 * @var Storehouse $storehouse
		 */
		foreach ($this->repository->all() as $storehouse) {
			/**
			 * @var $storehouseProduct StorehouseProduct
			 */
			foreach ($storehouse->products as $storehouseProduct) {

				$count++;
				$this->_sheet
					->setCellValue('A' . $count, $count - 1)
					->setCellValue('B' . $count, $storehouseProduct->product->sku)
					->setCellValue('C' . $count, $storehouseProduct->product->name)
					->setCellValue('D' . $count, $storehouseProduct->quantity)

					;
				$this->_sheet
					->setCellValue('E' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($storehouse->getAttribute('uploaded_at')))
					->getStyle('E' . $count)
					->getNumberFormat()
					->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
				$this->_sheet
					->setCellValue('F' . $count, $storehouseProduct->product->price->price)
					->getStyle('F' . $count)
					->getNumberFormat()
					->setFormatCode('# ##0.00_-"EUR"');

				$this->_sheet
					->setCellValue('G' . $count, $storehouse->name)
					->setCellValue('H' . $count, $storehouse->addresses()->pluck('name')->implode(', '));
					
			}
		}

		$this->_sheet->getColumnDimension('A')->setWidth(5);
		$this->_sheet->getColumnDimension('B')->setAutoSize(true);
		$this->_sheet->getColumnDimension('C')->setAutoSize(true);
		$this->_sheet->getColumnDimension('D')->setAutoSize(true);
		$this->_sheet->getColumnDimension('E')->setWidth(25);
		$this->_sheet->getColumnDimension('F')->setAutoSize(true);
		$this->_sheet->getColumnDimension('G')->setAutoSize(true);
		$this->_sheet->getColumnDimension('H')->setAutoSize(true);


	}

}
