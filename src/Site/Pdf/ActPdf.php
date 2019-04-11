<?php

namespace QuadStudio\Service\Site\Pdf;


use QuadStudio\Service\Site\Support\Pdf;

class ActPdf extends Pdf
{

    function build()
    {
        $contragent = $this->model->details()->where('our', 0)->firstOrFail();
        $organization = $this->model->details()->where('our', 1)->firstOrFail();
        $font_size = $this->defaults['font_size'];
        $font_size_small = $this->defaults['font_size_small'];
        $line_height = $this->defaults['line_height'];
        $this->AddPage();
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(0, $line_height, w1251(trans('site::act.pdf.number', [
            'number' => $this->model->number(),
            'date'   => $this->model->created_at->format('d.m.Y')
        ])), 0, 1, 'C');
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(0, $line_height, w1251(trans('site::act.pdf.contract') . ' ' . $contragent->contract), 0, 1, 'C');
        $this->ln(5);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->ln(5);

        $this->Cell(30, $line_height, w1251(trans('site::act.pdf.customer')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->SetX(40);
        $this->MultiCell(150, $line_height, w1251($contragent->name . ', ' . $contragent->address), 0, 'L');
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(30, $line_height, w1251(trans('site::act.pdf.executor')), 0, 0, 'L');
        $this->SetFont('Verdana', '', $font_size);
        $this->SetX(40);
        $this->MultiCell(150, $line_height, w1251($organization->name . ', ' . $organization->address), 0, 'L');
        $this->ln(5);
        $this->SetFont('Verdana', '', $font_size_small);
        $this->Cell(10, $line_height, w1251('№'), 1, 0, 'C');
        $this->Cell(110, $line_height, w1251(trans('site::act.pdf.table.service')), 1, 0, 'C');
        $this->Cell(20, $line_height, w1251(trans('site::act.pdf.table.quantity')), 1, 0, 'C');
        $this->Cell(10, $line_height, w1251(trans('site::act.pdf.table.unit')), 1, 0, 'C');
        $this->Cell(20, $line_height, w1251(trans('site::act.pdf.table.price')), 1, 0, 'C');
        $this->Cell(20, $line_height, w1251(trans('site::act.pdf.table.cost')), 1, 1, 'C');
        foreach ($this->model->contents as $key => $repair) {
            $this->Cell(10, $line_height, $key + 1, 1, 0, 'C');
            $this->Cell(110, $line_height, w1251(trans('site::act.pdf.table.text.'.$this->model->type_id, [
                'repair_id' => $repair->id,
                'repair_date' => $this->model->created_at->format('d.m.Y')
            ])), 1, 0, 'L');
            $this->Cell(20, $line_height, 1, 1, 0, 'C');
            $this->Cell(10, $line_height, w1251(trans('site::act.pdf.table.unit_row')), 1, 0, 'C');
            $this->Cell(20, $line_height, number_format($repair->total, 2, '.', ' '), 1, 0, 'R');
            $this->Cell(20, $line_height, number_format($repair->total, 2, '.', ' '), 1, 1, 'R');
        }
        $this->ln(2);
        $this->SetFont('Verdana', 'B', $font_size);
        $this->Cell(160, $line_height, w1251(trans('site::act.pdf.table.total')), 0, 0, 'R');
        $this->Cell(30, $line_height, number_format($this->model->total, 2, '.', ' '), 0, 1, 'R');
        $this->SetFont('Verdana', 'B', $font_size);
        $detail = $this->model->details()->where('our', 0)->first();
        $this->Cell(160, $line_height, w1251(trans('site::act.pdf.nds_'.$detail->nds_act)), 0, 0, 'R');
        if($detail->nds_act == 1){
            $nds = round($this->model->total / (100 + $detail->nds_value) * $detail->nds_value, 2);
            $this->Cell(30, $line_height, number_format($nds, 2, '.', ' '), 0, 1, 'R');
        }
        $this->ln(5);
        $this->SetFont('Verdana', '', $font_size_small);
        $this->Cell(0, $line_height, w1251(trans('site::act.pdf.total_service', [
            'num2str' => num2str($this->model->total)
        ])), 0, 1, 'L');
        $this->MultiCell(190, $line_height,  w1251(trans('site::act.pdf.pretension_text')), 0, 'L');
        $this->ln(10);
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(20, $line_height, w1251(trans('site::act.pdf.customer')), 0, 0, 'L');
        $this->Cell(5, $line_height, '', 0, 0, 'L');
        $this->Cell(60, $line_height, '', 'B', 0, 'L');
        $this->Cell(20, $line_height, '', 0, 0, 'L');
        $this->Cell(20, $line_height, w1251(trans('site::act.pdf.executor')), 0, 0, 'L');
        $this->Cell(5, $line_height, '', 0, 0, 'L');
        $this->Cell(60, $line_height, '', 'B', 1, 'L');
        //
        $this->SetFont('Verdana', '', $font_size_small);
        $this->Cell(25, $line_height, '', 0, 0, 'L');
        $this->Cell(60, $line_height, w1251(trans('site::act.pdf.sign')), 0, 0, 'C');
        $this->Cell(20, $line_height, '', 0, 0, 'L');
        $this->Cell(25, $line_height, '', 0, 0, 'L');
        $this->Cell(60, $line_height, w1251(trans('site::act.pdf.sign')), 0, 0, 'C');
        //
        $this->ln(10);
        $this->SetFont('Verdana', '', $font_size);
        $this->Cell(25, $line_height, '', 0, 0, 'L');
        $this->Cell(60, $line_height, w1251(trans('site::act.pdf.mp')), 0, 0, 'C');
        $this->Cell(20, $line_height, '', 0, 0, 'L');
        $this->Cell(25, $line_height, '', 0, 0, 'L');
        $this->Cell(60, $line_height, w1251(trans('site::act.pdf.mp')), 0, 0, 'C');

    }
}