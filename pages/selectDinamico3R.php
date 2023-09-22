<?php
	require ('conexion/bd.php');
	
	$id_bodega = $_POST['id_bodega'];
	$idCedi = $_POST['id_cedi'];
	$acentos = $mysqli->query("SET NAMES 'utf8'");
	$query =  $mysqli->query("SELECT * FROM documento WHERE tipo_documento = '$id_bodega' AND proceso = '$idCedi' AND vigente = 1 AND pre IS NULL");
	
	
	$html.= "<option value=''>Seleccione Documento</option>";
	
	while($rowM = $query->fetch_assoc())
	{
		$html.= "<option value='".$rowM['id']."'>".$rowM['nombres']."</option>";
	}
	
	echo $html;
?>