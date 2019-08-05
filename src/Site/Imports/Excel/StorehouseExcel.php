<?php

namespace QuadStudio\Service\Site\Imports\Excel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\BaseReader;
use QuadStudio\Service\Site\Http\Requests\StorehouseExcelRequest;
use QuadStudio\Service\Site\Models\Product;

class StorehouseExcel
{
    private $_data = [];

    /**
     * @param StorehouseExcelRequest $request
     * @return array
     */
    public function get(StorehouseExcelRequest $request)
    {

        $inputFileType = ucfirst($request->path->getClientOriginalExtension());
        $filterSubset = new StorehouseExcelLoadFilter();
        /** @var BaseReader $reader */
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setReadFilter($filterSubset);

        $spreadsheet = $reader->load($request->path->getPathname());

        $rowIterator = $spreadsheet->getActiveSheet()->getRowIterator();

        foreach ($rowIterator as $r => $row) {

            $cellIterator = $row->getCellIterator();

            foreach ($cellIterator as $c => $cell) {


                switch ($c) {
                    case 'A':
                        $sku = (string)trim($cell->getValue());
                        /** @var Product $product */
                        $product = Product::query()->where('sku', $sku)->firstOrFail();

                        break;
                    case 'B':

                        $quantity = (int)$cell->getValue();

                        break;
                }
            }
            array_push($this->_data, [
                'product_id' => $product->getKey(),
                'quantity'   => $quantity,
            ]);
        }

        return $this->_data;
    }
}
