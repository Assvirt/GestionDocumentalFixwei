<?php
include('reports/fpdf.php');
//header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=documento.pdf");
//include('fpdi.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image('../dist/img/FWLogoMorado.png', 10, 10, 40);
// <img src=""
$pdf->Output('ordenCompra.pdf', 'D');
//readfile('ordenCompra.pdf');