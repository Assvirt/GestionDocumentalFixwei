<?php

require '../vendor/autoload.php';
require 'conexion/bd.php';

require 'vendor\phpoffice\phpspreadsheet\src\PhpSpreadsheet\{Spreadsheet, IOFactory}';
  


$consultaproveedoresCriticidad = $mysqli->query("SELECT * FROM proveedoresCriticidad");

$dataExcel = new Spreadsheet();

$hojaExcel = $dataExcel->getActiveSheet();
$hojaExcel->setTitle("Proveedores Criticidad");

$hojaExcel->setCellValue('A1','Tipo');
$hojaExcel->setCellValue('B1','Descripcion');

$fila = 2;

while($row = $consultaproveedoresCriticidad->fecth_assoc()){
    $hojaExcel->setCellValue('A'.$fila,$rows['tipo']);
    $hojaExcel->setCellValue('B'.$fila,$rows['descripcion']);
    $fila++;
}



header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=DatosProveedor.xls');

$writer =IOFactory::createWriter($dataExcel,'xlsx');
$writer->save('php://output');
exit;
?>
