<?php

namespace QuadStudio\Service\Site\Exports\Excel;

use QuadStudio\Service\Site\Support\Excel;

abstract class StorehouseExcel extends Excel
{

	/** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet Sheet */
	protected $_sheet;


	/**
	 * @throws \PhpOffice\PhpSpreadsheet\Exception
	 */
	function build()
	{

		if (is_null($this->repository) && is_null($this->model)) {
			echo "Невозможно создать xls файл, т.к. не указан репозиторий с данными или модель";
			exit();
		}

		$this->getProperties()->setTitle(trans('site::storehouse.header.quantity'));

		$this->_sheet = $this->getActiveSheet();
		$this->_sheet->setTitle(trans('site::storehouse.header.quantity'));


	}

}
