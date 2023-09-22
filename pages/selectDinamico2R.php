<?php
	require ('conexion/bd.php');
	
	$idCedi = $_POST['id_cedi']; //idGrupo
	$acentos = $mysqli->query("SET NAMES 'utf8'");
	$queryM = $mysqli->query("SELECT documento.id, documento.tipo_documento  , tipoDocumento.nombre AS nombre, tipoDocumento.id AS id FROM documento
	INNER JOIN tipoDocumento WHERE proceso = '$idCedi' AND documento.tipo_documento = tipoDocumento.id AND documento.vigente = 1 AND documento.pre IS NULL group by tipoDocumento.id");  
	
	$html= "<option value='' selected  >Seleccionar Tipo Documento</option>";
	
	
	while($rowM = $queryM->fetch_assoc())
	{

	    $html.= "<option value='".$rowM['id']."'>".$rowM['nombre']."</option>";
	    
	}
	
	echo $html;
?>