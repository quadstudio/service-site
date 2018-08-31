<?php

namespace QuadStudio\Service\Site\Support;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Database\Eloquent\Model;

abstract class Pdf extends Fpdf
{
    protected $model;

    protected $defaults = [
        'font_size' => 9,
        'font_size_small' => 7,
        'line_height' => 5,
    ];

    /**
     * @param Model $model
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    public function render()
    {
        $this->SetFillColor(255, 255, 255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetMargins(10, 10, 10);
        $this->AddFont('verdana', '', 'verdana.php');
        $this->AddFont('verdana', 'B', 'verdanab.php');
        $this->AddFont('verdana', 'I', 'verdanai.php');
        $this->AddFont('verdana', 'U', 'verdanaz.php');
        $this->build();

        return response($this->Output(), 200)->header('Content-Type', 'application/pdf');
    }

    abstract function build();
}