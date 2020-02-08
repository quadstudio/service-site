<?php

namespace QuadStudio\Service\Site\Pdf;

use QuadStudio\Service\Site\Support\Pdf;

class CertificatePdf extends Pdf
{

    function build()
    {
        $font_size = $this->defaults['font_size'];
        $line_height = $this->defaults['line_height'];
        $this->AddPage();
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(0, $line_height, w1251(trans('site::certificate.pdf.name') . ' ' . $this->model->name), 0, 1, 'C');
        $this->Cell(0, $line_height, w1251(trans('site::certificate.pdf.created_at') . ' ' . $this->model->created_at->format('d.m.Y')), 0, 1, 'C');
    }
}