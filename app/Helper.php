<?php

use Codedge\Fpdf\Fpdf\Fpdf;

function get_tahun_akademik($field)
{
    $academic_year = \DB::table('academic_years')
        ->where('status', 'Aktif')
        ->first();
    return $academic_year->$field;
}

class PDF extends Fpdf
{
    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Print centered page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
