<?php
require '../vendor/autoload.php';
//use vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Worksheet;
require 'conexion/bd.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;



$documento = new Spreadsheet();

$hojaDeGrupos = $documento->getActiveSheet();

$hojaDeGrupos->getStyle('D1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeGrupos->getStyle('C1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');
            
$hojaDeGrupos->getStyle('B1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeGrupos->getStyle('A1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');


$hojaDeGrupos->getColumnDimension('A')->setAutoSize(true);

$hojaDeGrupos->getColumnDimension('B')->setAutoSize(true);

$hojaDeGrupos->getColumnDimension('C')->setAutoSize(true);

$hojaDeGrupos->getColumnDimension('D')->setAutoSize(true);

$hojaDeGrupos->setTitle("Producto Grupos");

//Encabezado Grupo Producto

$encabezado = ["Identificador","Grupo", "Subgrupo", "Descripcion"];

$hojaDeGrupos->fromArray($encabezado, null, 'A1');

$consultaGrupo = $mysqli->query("SELECT * FROM proveedoresProductoGrupo")or die(mysql_error());

$numeroDeFila = 2;

while ($grupo = $consultaGrupo->fetch_array()) {

        $consultaSubGrupo=$mysqli->query("SELECT * FROM proveedoresProductoSubGrupo WHERE id='".$grupo['sub']."' ");
        $extraerSubGrupo=$consultaSubGrupo->fetch_array(MYSQLI_ASSOC);

    $subGrupoID=utf8_encode($extraerSubGrupo['grupo']); /// se incluye acotejamiento, para evitar que salfa FALSE en el excel
    $idGru = utf8_encode($grupo['id']);
    $gru = utf8_encode($grupo['grupo']);//$tipo->codigo;
    $des = utf8_encode($grupo['descripcion']);//$tipo->descripcion;
    
    $hojaDeGrupos->setCellValueByColumnAndRow(1, $numeroDeFila, $idGru);
    $hojaDeGrupos->setCellValueByColumnAndRow(2, $numeroDeFila, $gru);
    $hojaDeGrupos->setCellValueByColumnAndRow(3, $numeroDeFila, $subGrupoID);
    $hojaDeGrupos->setCellValueByColumnAndRow(4, $numeroDeFila, $des);
    
    $numeroDeFila++;
}

//Hoja Identidicadores

$hojaDeProductosSub = $documento->createSheet();

/*$hojaDeProductosSub->getStyle('C1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');*/

$hojaDeProductosSub->getStyle('B1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeProductosSub->getStyle('A1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeProductosSub->getColumnDimension('A')->setAutoSize(true);
$hojaDeProductosSub->getColumnDimension('B')->setAutoSize(true);
//$hojaDeProductosSub->getColumnDimension('C')->setAutoSize(true);
$hojaDeProductosSub->setTitle("Identificador");


$encabezadoB = ["Identificador", "Descripcion"];
$hojaDeProductosSub->fromArray($encabezadoB, null, 'A1');

# Obtener los identificadores de MySQL
$consultaSG = $mysqli->query("SELECT * FROM proveedoresProductoIdentificador")or die(mysql_error());

$numeroDeFila = 2;
while ($prductosSG = $consultaSG->fetch_array()){

    //$idGrupo = utf8_encode($prductosSG['id']);
    $grupo = utf8_encode($prductosSG['grupo']);
    $descripcion = utf8_encode($prductosSG['descripcion']);

    
    # Escribir en el documento
    //$hojaDeProductosSub->setCellValueByColumnAndRow(1, $numeroDeFila, $idGrupo);
    $hojaDeProductosSub->setCellValueByColumnAndRow(1, $numeroDeFila, $grupo);
    $hojaDeProductosSub->setCellValueByColumnAndRow(2, $numeroDeFila, $descripcion);
    
    $numeroDeFila++;
}

// unidad de empaque
$hojaDeUnidadEmpaque = $documento->createSheet();

$hojaDeUnidadEmpaque->getStyle('B1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeUnidadEmpaque->getStyle('A1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeUnidadEmpaque->getColumnDimension('A')->setAutoSize(true);
$hojaDeUnidadEmpaque->getColumnDimension('B')->setAutoSize(true);

$hojaDeUnidadEmpaque->setTitle("Unidad de Empaque");


$encabezado = ["Unidad de empaque (abreviatura)", "Descripcion"];
$hojaDeUnidadEmpaque->fromArray($encabezado, null, 'A1');

# Obtener los proveedores de MySQL
$consultaUnidadEmpaque = $mysqli->query("SELECT * FROM proveedoresProductoEmpaque")or die(mysql_error());

$numeroDeFila = 2;
while ($UnidadEmpaque = $consultaUnidadEmpaque->fetch_assoc()) {

    $grupoUE = utf8_encode($UnidadEmpaque['grupo']);
    $descripcionUE = utf8_encode($UnidadEmpaque['descripcion']);
    
    
    # Escribir en el documento
    $hojaDeUnidadEmpaque->setCellValueByColumnAndRow(1, $numeroDeFila, $grupoUE);
    $hojaDeUnidadEmpaque->setCellValueByColumnAndRow(2, $numeroDeFila, $descripcionUE);
    
    
    $numeroDeFila++;
}

//Hoja Unidad de medida

$hojaDeUnidadMedida = $documento->createSheet();
/*
$hojaDeUnidadMedida->getStyle('C1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');
*/
$hojaDeUnidadMedida->getStyle('B1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeUnidadMedida->getStyle('A1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeUnidadMedida->getColumnDimension('A')->setAutoSize(true);
$hojaDeUnidadMedida->getColumnDimension('B')->setAutoSize(true);
//$hojaDeUnidadMedida->getColumnDimension('C')->setAutoSize(true);


$hojaDeUnidadMedida->setTitle("Unidad de Medida");



$encabezado = ["Unidad de medida (abreviatura)", "Descripcion"];
$hojaDeUnidadMedida->fromArray($encabezado, null, 'A1');

# Obtener los proveedores de MySQL
    $consultaMedidaProducto = $mysqli->query("SELECT * FROM proveedoresProductoMedida")or die(mysql_error());


$numeroDeFila = 2;
while ($proveedoresProductoMed = $consultaMedidaProducto->fetch_assoc()) {

    //$id = $proveedoresProductoMed['id'];//$proveedoresCiu->id;
    $grupo = utf8_encode($proveedoresProductoMed['grupo']);// $proveedoresCiu->Municipio;
    $des = utf8_encode($proveedoresProductoMed['descripcion']);//$proveedoresCiu->Departamento;
    
    
    # Escribir en el documento
    //$hojaDeUnidadMedida->setCellValueByColumnAndRow(1, $numeroDeFila, $id);
    $hojaDeUnidadMedida->setCellValueByColumnAndRow(1, $numeroDeFila, $grupo);
    $hojaDeUnidadMedida->setCellValueByColumnAndRow(2, $numeroDeFila, $des);
    
    $numeroDeFila++;
}


/////////// Tipo De impuesto

$hojaDeTipoImpuesto = $documento->createSheet();
/*
$hojaDeTipoImpuesto->getStyle('D1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeTipoImpuesto->getStyle('C1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');
*/
$hojaDeTipoImpuesto->getStyle('B1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeTipoImpuesto->getStyle('A1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeTipoImpuesto->getColumnDimension('A')->setAutoSize(true);
$hojaDeTipoImpuesto->getColumnDimension('B')->setAutoSize(true);
//$hojaDeTipoImpuesto->getColumnDimension('C')->setAutoSize(true);
//$hojaDeTipoImpuesto->getColumnDimension('D')->setAutoSize(true);


$hojaDeTipoImpuesto->setTitle("Tipo De Impuesto");



$encabezado = ["Nombre del impuesto", "Descripcion"];
$hojaDeTipoImpuesto->fromArray($encabezado, null, 'A1');

# Obtener los proveedores de MySQL
    $consultaImpuestoProducto = $mysqli->query("SELECT * FROM proveedoresTipoImpuesto")or die(mysql_error());


$numeroDeFila = 2;
while ($proveedoresProductoImpu = $consultaImpuestoProducto->fetch_assoc()) {

    //$id = $proveedoresProductoImpu['id'];//$proveedoresCiu->id;
    $grupo = utf8_encode($proveedoresProductoImpu['grupo']);// $proveedoresCiu->Municipio;
    $descripcion = utf8_encode($proveedoresProductoImpu['descripcion']);//$proveedoresCiu->Departamento;
    //$descuento = utf8_encode($proveedoresProductoImpu['des']);
    
    
    
    # Escribir en el documento
    //$hojaDeTipoImpuesto->setCellValueByColumnAndRow(1, $numeroDeFila, $id);
    $hojaDeTipoImpuesto->setCellValueByColumnAndRow(1, $numeroDeFila, $grupo);
    $hojaDeTipoImpuesto->setCellValueByColumnAndRow(2, $numeroDeFila, $descripcion);
    //$hojaDeTipoImpuesto->setCellValueByColumnAndRow(3, $numeroDeFila, $descuento);
    
    $numeroDeFila++;
}

/////////// Tiempo de servicio

$hojaDeTiempodeServicio = $documento->createSheet();

$hojaDeTiempodeServicio->getStyle('A1')
            ->getFill()
            ->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('9BC2E6');

$hojaDeTiempodeServicio->getColumnDimension('A')->setAutoSize(true);



$hojaDeTiempodeServicio->setTitle("Tiempo de servicio");



$encabezado = ["Tiempo de servicio"];
$hojaDeTiempodeServicio->fromArray($encabezado, null, 'A1');

# Obtener los proveedores de MySQL
    $consultaTiempodeServicio = $mysqli->query("SELECT * FROM proveedoresProductoTiempo")or die(mysql_error());


$numeroDeFila = 2;
while ($proveedoresTiempodeServicio = $consultaTiempodeServicio->fetch_assoc()) {

   
    $nombreTiempoServicio = utf8_encode($proveedoresTiempodeServicio['grupo']);
    
    
    
    # Escribir en el documento
    $hojaDeTiempodeServicio->setCellValueByColumnAndRow(1, $numeroDeFila, $nombreTiempoServicio);
    
    $numeroDeFila++;
}


# Crear un "escritor"
$writer = new Xlsx($documento);

# Le pasamos la ruta de guardado
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="datosProductos.xlsx"');
        $writer->save('php://output');


?>