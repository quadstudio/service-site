<?php

namespace QuadStudio\Service\Site\Support;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use QuadStudio\Repo\Eloquent\Repository;

abstract class Excel extends Spreadsheet
{


    public function render(Repository $repository)
    {
        $this->build($repository);
        $this->getProperties()
            ->setCreator(Auth::user()->name)
            ->setLastModifiedBy(Auth::user()->name)
            ->setTitle(trans('site::repair.repairs'));
        $this->getActiveSheet()->setTitle(trans('site::repair.repairs'));
        $this->setActiveSheetIndex(0);
        $this->_checkoutput();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . date('Y-m-d') . '_repairs.xlsx"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public'); // HTTP/1.0
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this, 'Xlsx');
        $writer->save('php://output');
        exit();
    }

    abstract function build(Repository $repository);

    protected function _checkoutput()
    {

        if (PHP_SAPI != 'cli') {
            if (headers_sent($filename, $linenum)) {
                echo "Невозможно создать xls файл, т.к. заголовки уже были отправлены в $filename в строке $linenum";
                exit();
            }
        }
        if (ob_get_length()) {
            // The output buffer is not empty
            if (preg_match('/^(\xEF\xBB\xBF)?\s*$/', ob_get_contents())) {
                // It contains only a UTF-8 BOM and/or whitespace, let's clean it
                ob_clean();
            } else {
                echo "Невозможно создать xls файл, т.к. заголовки уже были отправлены";
                exit();
            }

        }
    }
}