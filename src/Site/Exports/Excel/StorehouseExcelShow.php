<?php

namespace QuadStudio\Service\Site\Exports\Excel;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use QuadStudio\Service\Site\Models\StorehouseProduct;

class StorehouseExcelShow extends StorehouseExcel
{

	/**
	 * @throws \PhpOffice\PhpSpreadsheet\Exception
	 */
	function build()
	{
		parent::build();

		$count = 1;

		foreach (trans('site::storehouse.excel.show') as $cell => $value) {
			$this->_sheet->setCellValue($cell . $count, $value);
		}
		/**
		 * @var $storehouseProduct StorehouseProduct
		 */
		foreach ($this->model->products as $storehouseProduct) {

			$count++;
			$this->_sheet
				->setCellValue('A' . $count, $count - 1)
				->setCellValue('B' . $count, $storehouseProduct->product->sku)
				->setCellValue('C' . $count, $storehouseProduct->product->name)
				->setCellValue('D' . $count, $storehouseProduct->quantity);

			$this->_sheet
				->setCellValue('E' . $count, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($this->model->getAttribute('uploaded_at')))
				->getStyle('E' . $count)
				->getNumberFormat()
				->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

		}

		$this->_sheet->getColumnDimension('A')->setWidth(5);
		$this->_sheet->getColumnDimension('B')->setAutoSize(true);
		$this->_sheet->getColumnDimension('C')->setAutoSize(true);
		$this->_sheet->getColumnDimension('D')->setAutoSize(true);
		$this->_sheet->getColumnDimension('E')->setWidth(25);

	}

}
