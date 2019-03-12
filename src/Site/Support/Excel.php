<?php

namespace QuadStudio\Service\Site\Support;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use QuadStudio\Repo\Eloquent\Repository;

abstract class Excel extends Spreadsheet
{
    /**
     * @var Model|null
     */
    protected $model;

    /**
     * @var Repository|null
     */
    protected $repository;

    /**
     * @param Model $model
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    public function render()
    {
        $this->build();
        $this->getProperties()
            ->setCreator(Auth::user()->name)
            ->setLastModifiedBy(Auth::user()->name);

        $this->setActiveSheetIndex(0);
        $this->_checkoutput();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . date('Y-m-d H:i') . '_file.xlsx"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public'); // HTTP/1.0
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this, 'Xlsx');
        $writer->save('php://output');
        exit();
    }

    abstract function build();

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