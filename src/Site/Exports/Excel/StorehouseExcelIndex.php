<?php

namespace QuadStudio\Service\Site\Exports\Excel;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use QuadStudio\Service\Site\Models\Storehouse;
use QuadStudio\Service\Site\Models\StorehouseProduct;

class StorehouseExcelIndex extends StorehouseExcel
{

	/**
	 * @throws \PhpOffice\PhpSpreadsheet\Exception
	 */
	function build()
	{
		parent::build();

		$count = 1;

		foreach (trans('site::storehouse.excel.index') as $cell => $value) {
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
					->setCellValue('B' . $count, $storehouse->user->name)
					->setCellValue('C' . $count, $storehouse->name)
					->setCellValue('D' . $count, $storehouse->user->region->name)
					->setCellValue('E' . $count, $storehouseProduct->product->sku)
					->setCellValue('F' . $count, $storehouseProduct->product->name)
					->setCellValue('G' . $count, $storehouseProduct->quantity);

				$this->_sheet
					->setCellValue('H' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($storehouse->getAttribute('uploaded_at')))
					->getStyle('H' . $count)
					->getNumberFormat()
					->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

			}
		}

		$this->_sheet->getColumnDimension('A')->setWidth(5);
		$this->_sheet->getColumnDimension('B')->setAutoSize(true);
		$this->_sheet->getColumnDimension('C')->setAutoSize(true);
		$this->_sheet->getColumnDimension('D')->setAutoSize(true);
		$this->_sheet->getColumnDimension('E')->setAutoSize(true);
		$this->_sheet->getColumnDimension('F')->setAutoSize(true);
		$this->_sheet->getColumnDimension('G')->setAutoSize(true);
		$this->_sheet->getColumnDimension('H')->setWidth(25);

	}

}
