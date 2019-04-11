<?php

namespace QuadStudio\Service\Site\Exports\Excel;

use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Support\Excel;

class UserExcel extends Excel
{
    /** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet Sheet */
    private $_sheet;


    function build()
    {
        if (is_null($this->repository)) {
            echo "Невозможно создать xls файл, т.к. не указан репозиторий с данными";
            exit();
        }
        $this->getProperties()->setTitle(trans('site::user.users'));
        $this->getActiveSheet()->setTitle(trans('site::user.users'));
        $this->_sheet = $this->getActiveSheet();
        $count = 1;
        foreach (trans('site::user.excel') as $cell => $value) {
            $this->_sheet->setCellValue($cell . $count, $value);
        }

        /**
         * @var int $key
         * @var User $user
         */
        foreach ($this->repository->all() as $key => $user) {
            $count++;
            $this->_build($user, $count);
        }

    }

    private function _build(User $user, $count)
    {
        $this->_sheet
            ->setCellValue('A' . $count, $count - 1)
            ->setCellValue('B' . $count, $user->getAttribute('name'))
            ->setCellValue('C' . $count, $user->getAttribute('email'))
            ->setCellValue('D' . $count, $user->getAttribute('guid'))
            ->setCellValue('F' . $count, $user->currency->getAttribute('name'))
            ->setCellValue('G' . $count, $user->region->getAttribute('name'));
    }
}
