<?php
/**
 * Created by PhpStorm.
 * User: user097
 * Date: 29.08.2018
 * Time: 11:18
 */

namespace Site\Support;


use Codedge\Fpdf\Fpdf\Fpdf;

class Pdf extends Fpdf
{
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->SetFillColor(255, 255, 255);
        $this->SetDrawColor(0, 0, 0);
        $this->AddFont('verdana', '',  'verdana.php');
        $this->AddFont('verdana', 'B', 'verdanab.php');
        $this->AddFont('verdana', 'I', 'verdanai.php');
        $this->AddFont('verdana', 'U', 'verdanaz.php');

    }

    public function render(){
        return response($this->Output(), 200)->header('Content-Type', 'application/pdf');
    }
}