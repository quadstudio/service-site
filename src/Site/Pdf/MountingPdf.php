<?php

namespace QuadStudio\Service\Site\Pdf;

use QuadStudio\Service\Site\Support\Pdf;

class MountingPdf extends Pdf
{

    function build()
    {
        $font_size = $this->defaults['font_size'];
        $font_size_small = $this->defaults['font_size_small'];
        $line_height = $this->defaults['line_height'];
        $this->AddPage();
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(0, $line_height, w1251(trans('site::mounting.pdf.annex')), 0, 1, 'C');
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(0, $line_height, w1251(trans('site::mounting.pdf.contract') . ' ' . $this->model->contragent->contract), 0, 1, 'C');
        $this->ln(5);
        // Город
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(13, $line_height, w1251(trans('site::mounting.pdf.city')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(177, $line_height, w1251($this->model->user->address()->locality), 0, 1, 'L');
        // Организация
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(53, $line_height, w1251(trans('site::mounting.pdf.organization')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(137, $line_height, w1251($this->model->contragent->name), 0, 1, 'L');
        // Акт
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(0, 14, w1251(trans('site::mounting.pdf.title')), 0, 1, 'C');
        // Клиент
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(43, $line_height, w1251(trans('site::mounting.pdf.client')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(147, $line_height, w1251($this->model->client), 0, 1, 'L');
        // Адрес
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(14, $line_height, w1251(trans('site::mounting.pdf.address')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(176, $line_height, w1251($this->model->address), 0, 1, 'L');
        // Телефон
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(38, $line_height, w1251(trans('site::mounting.pdf.phone')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(162, $line_height, w1251($this->model->country->phone . $this->model->phone_primary), 0, 1, 'L');
        //
        $this->ln(2);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->ln(2);
        // Модель котла
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(28, $line_height, w1251(trans('site::mounting.pdf.model')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(162, $line_height, w1251($this->model->product->brand->name . ' ' . $this->model->product->name), 0, 1, 'L');
        // Серийный номер
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(34, $line_height, w1251(trans('site::mounting.pdf.serial')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(166, $line_height, w1251($this->model->serial_id), 0, 1, 'L');
        // Дата продажи
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(28, $line_height, w1251(trans('site::mounting.pdf.date_trade')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(164, $line_height, $this->model->date_trade->format('d.m.Y'), 0, 1, 'L');
        //
        $this->ln(2);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->ln(2);
        // Дата выполенния работ
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(37, $line_height, w1251(trans('site::mounting.pdf.date_mounting')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(153, $line_height, $this->model->date_mounting->format('d.m.Y'), 0, 1, 'L');
        $this->SetFont('Verdana', 'B', $font_size);
        // Исполнитель
        $y = $this->GetY();
        $this->SetXY(10, $y + 16);
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(30, $line_height, w1251(trans('site::mounting.pdf.executor')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(100, $line_height, w1251($this->model->engineer->name), 'B', 0, 'C');
        $this->Cell(10, $line_height, '/', 0, 0, 'C');
        $this->Cell(50, $line_height, '', 'B', 1, 'L');
        $this->SetFont('Verdana', '', $font_size_small);
        $this->Cell(30, $line_height, '', 0, 0, 'L');
        $this->Cell(100, $line_height, w1251(trans('site::mounting.pdf.fio')), 0, 0, 'C');
        $this->Cell(10, $line_height, '', 0, 0, 'C');
        $this->Cell(50, $line_height, w1251(trans('site::mounting.pdf.sign')), 0, 1, 'C');
        //
        $this->ln(5);
        $this->SetFont('Verdana', 'I', $font_size_small);
        $this->Cell(120, $line_height, w1251(trans('site::mounting.pdf.confirm')), 0, 0, 'L');
        $this->Cell(70, $line_height, '', 'B', 1, 'C');
        $this->Cell(120, $line_height, '', 0, 0, 'L');
        $this->Cell(70, $line_height, w1251(trans('site::mounting.pdf.sign_client')), 0, 1, 'C');
        //
        $this->ln(2);
        //$this->Line(10, $this->GetY(), 200, $this->GetY());
        //
        $this->SetFont('Verdana', 'B', $font_size);
        //$this->ln(5);
        $y = $this->GetY();
//        $this->SetX(20);
//        $this->MultiCell(170, 4, w1251(trans('site::mounting.pdf.cost')), 0, 'C');
//        $this->ln(5);
        $this->setXY(100, $y);
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(140, $line_height, w1251(trans('site::mounting.pdf.table.total')), 0, 0, 'R');
        $this->Cell(30, $line_height, number_format($this->model->total, 2, '.', ' '), 0, 0, 'R');
        $this->Cell(20, $line_height, w1251(trans('site::mounting.pdf.table.rub')), 0, 1, 'R');
        $this->ln(5);
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(140, $line_height, w1251(trans('site::mounting.pdf.table.total')), 0, 0, 'R');
        $this->Cell(30, $line_height, number_format($this->model->total, 2, '.', ' '), 0, 0, 'R');
        $this->Cell(20, $line_height, w1251(trans('site::mounting.pdf.table.rub')), 0, 1, 'R');
        $this->ln(5);
        $this->SetFont('Verdana', '', $font_size_small);
        $this->Cell(60, $line_height, '', 'B', 1, 'C');
        $this->Cell(60, $line_height, w1251(trans('site::mounting.pdf.sign')), 0, 1, 'C');
        $this->ln(5);
        $this->Cell(60, $line_height, w1251(trans('site::mounting.pdf.mp')), 0, 1, 'C');
    }
}