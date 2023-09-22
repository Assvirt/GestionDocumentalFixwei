<?php

require '../vendor/autoload.php';
//use vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Worksheet;
require 'conexion/bd.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use vendor\phpoffice\phpspreadsheet\src\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$consultaCriticidadProveedor=$mysqli->query("SELECT * FROM proveedoresCriticidad");
$consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresTipo");

///////////// Hoja de criticidad de proveedores
$hojaCriticidad = new Spreadsheet();
$sheetCriticidad = $hojaCriticidad->getActiveSheet();
$sheetCriticidad ->setTitle("Criticidad");



$sheetCriticidad->setCellValue('A1', 'Tipo Criticidad');

$fila = 2;

while($row = $consultaCriticidadProveedor->fetch_array()){
    $sheetCriticidad->setCellValue('B'.$fila,$row['tipo']);
    $fila++;
    
}

/////////// Hoja de tipo de proveedores
$hojaTipoProveedor = new Spreadsheet();
$hojaDeProveedoresTipo = $hojaTipoProveedor->getActiveSheet();
$hojaDeProveedoresTipo->setTitle("Proveedores Tipo");


$sheetTipo->setCellValue('B1', 'Tipo Proveedor');

$fila = 2;

$hojaDeProveedoresGrupo = $spreadsheet->createSheet();
$hojaDeProveedoresGrupo->setTitle("Proveedores Grupo");

while($row2 = $consultaTipoProveedor->fetch_array()){
 
    $sheet->setCellValue('B'.$fila2,$row2['tipo']);
    $fila++;
    
}


$writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="excelPrueba.xlsx"');
        $writer->save('php://output');


?>