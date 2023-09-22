<?php
require '../vendor/autoload.php';
//use vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Worksheet;
require 'conexion/bd.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;



$documento = new Spreadsheet();

$hojaDeTipo = $documento->getActiveSheet();

$hojaDeTipo->getStyle('B1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeTipo->getStyle('A1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');


$hojaDeTipo->getColumnDimension('A')->setAutoSize(true);

$hojaDeTipo->getColumnDimension('B')->setAutoSize(true);

$hojaDeTipo->setTitle("Tipo Proveedor");

//Encabezado Tipo Proveedor

$encabezado = ["Tipo Proveedor", "Descripcion"];

$hojaDeTipo->fromArray($encabezado, null, 'A1');

$consultaTipo = $mysqli->query("SELECT * FROM proveedoresTipo")or die(mysql_error());

$numeroDeFilaTipoPr = 2;

while ($tipo = $consultaTipo->fetch_array()) {

    $tip = utf8_encode($tipo['tipo']);
    $des = utf8_encode($tipo['descripcion']);
    
    $hojaDeTipo->setCellValueByColumnAndRow(1, $numeroDeFilaTipoPr, $tip);
    $hojaDeTipo->setCellValueByColumnAndRow(2, $numeroDeFilaTipoPr, $des);
    
    $numeroDeFilaTipoPr++;
}

//Hoja proveedores grupo

$hojaDeProveedoresG = $documento->createSheet();

$hojaDeProveedoresG->getStyle('B1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeProveedoresG->getStyle('A1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeProveedoresG->getColumnDimension('A')->setAutoSize(true);
$hojaDeProveedoresG->getColumnDimension('B')->setAutoSize(true);
$hojaDeProveedoresG->setTitle("Grupo Proveedores");


$encabezadoB = ["Grupo", "Descripcion"];
$hojaDeProveedoresG->fromArray($encabezadoB, null, 'A1');

# Obtener los proveedores de MySQL
$consultaG = $mysqli->query("SELECT * FROM proveedoresGrupo")or die(mysql_error());

$numeroDeFila = 2;
while ($proveedoresG = $consultaG->fetch_array()){

    
    $grupo = utf8_encode($proveedoresG['grupo']);
    $descripcion = utf8_encode($proveedoresG['descripcion']);

    
    # Escribir en el documento
    
    $hojaDeProveedoresG->setCellValueByColumnAndRow(1, $numeroDeFila, $grupo);
    $hojaDeProveedoresG->setCellValueByColumnAndRow(2, $numeroDeFila, $descripcion);
    
    $numeroDeFila++;
}


$hojaDeProveedoresC = $documento->createSheet();

$hojaDeProveedoresC->getStyle('B1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeProveedoresC->getStyle('A1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeProveedoresC->getColumnDimension('A')->setAutoSize(true);
$hojaDeProveedoresC->getColumnDimension('B')->setAutoSize(true);

$hojaDeProveedoresC->setTitle("Criticidad Proveedores");


$encabezado = ["Criticidad", "Descripcion"];
$hojaDeProveedoresC->fromArray($encabezado, null, 'A1');

# Obtener los proveedores de MySQL
$consultaC = $mysqli->query("SELECT * FROM proveedoresCriticidad")or die(mysql_error());

$numeroDeFila = 2;
while ($proveedoresC = $consultaC->fetch_assoc()) {

    $criticidad = $proveedoresC['tipo'];
    $descripcionC = $proveedoresC['descripcion'];
    
    
    # Escribir en el documento
    $hojaDeProveedoresC->setCellValueByColumnAndRow(1, $numeroDeFila, $criticidad);
    $hojaDeProveedoresC->setCellValueByColumnAndRow(2, $numeroDeFila, $descripcionC);
    
    $numeroDeFila++;
}

//Hoja Departamento Ciudades Proveedores

$hojaDeProveedoresCiudad = $documento->createSheet();

$hojaDeProveedoresCiudad->getStyle('C1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeProveedoresCiudad->getStyle('B1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeProveedoresCiudad->getStyle('A1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeProveedoresCiudad->getColumnDimension('A')->setAutoSize(true);
$hojaDeProveedoresCiudad->getColumnDimension('B')->setAutoSize(true);
$hojaDeProveedoresCiudad->getColumnDimension('C')->setAutoSize(true);

$hojaDeProveedoresCiudad->setTitle("Departamento Ciudad Codigo");



$encabezado = ["Codigo", "Ciudad", "Departamento"];
$hojaDeProveedoresCiudad->fromArray($encabezado, null, 'A1');

# Obtener los proveedores de MySQL
    $consultaCiudad = $mysqli->query("SELECT municipios.id,municipios.nombre AS Municipio, departamentos.nombre AS Departamento FROM municipios INNER JOIN departamentos ON municipios.departamento_id = departamentos.id")or die(mysql_error());


$numeroDeFila = 2;
while ($proveedoresCiu = $consultaCiudad->fetch_assoc()) {

    $id = $proveedoresCiu['id'];//$proveedoresCiu->id;
    $municipio = utf8_encode($proveedoresCiu['Municipio']);// $proveedoresCiu->Municipio;
    $ciudad = utf8_encode($proveedoresCiu['Departamento']);//$proveedoresCiu->Departamento;
    
    
    # Escribir en el documento
    $hojaDeProveedoresCiudad->setCellValueByColumnAndRow(1, $numeroDeFila, $id);
    $hojaDeProveedoresCiudad->setCellValueByColumnAndRow(2, $numeroDeFila, $municipio);
    $hojaDeProveedoresCiudad->setCellValueByColumnAndRow(3, $numeroDeFila, $ciudad);
    
    $numeroDeFila++;
}



# Crear un "escritor"
$writer = new Xlsx($documento);

# Le pasamos la ruta de guardado
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="datosProveedoresInscripcion.xlsx"');
        $writer->save('php://output');


?>