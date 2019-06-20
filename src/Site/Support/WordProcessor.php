<?php

namespace QuadStudio\Service\Site\Support;

use PhpOffice\PhpWord\TemplateProcessor;
use QuadStudio\Service\Site\Models\Contract;

abstract class WordProcessor
{

    /**
     * @var Contract
     */
    protected $contract;
    /**
     * @var TemplateProcessor
     */
    protected $templateProcessor;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    public function render()
    {
        $this->build();
        $this->_checkoutput();
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $this->contract->type->file->name . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $this->templateProcessor->saveAs('php://output');
        exit();
    }

    abstract function build();

    protected function _checkoutput()
    {

        if (PHP_SAPI != 'cli') {
            if (headers_sent($filename, $linenum)) {
                echo "Невозможно создать docx файл, т.к. заголовки уже были отправлены в {$filename} в строке {$linenum}";
                exit();
            }
        }
        if (ob_get_length()) {
            // The output buffer is not empty
            if (preg_match('/^(\xEF\xBB\xBF)?\s*$/', ob_get_contents())) {
                // It contains only a UTF-8 BOM and/or whitespace, let's clean it
                ob_clean();
            } else {
                echo "Невозможно создать docx файл, т.к. заголовки уже были отправлены";
                exit();
            }

        }
    }
}