<?php
	require ('conexion.php');
	
	$id_producto = $_POST['id_producto']; //
	 $acentos = $mysqli->query("SET NAMES 'utf8'");
	$query = "SELECT proveedores.*, proveedorProductos.*, proveedorProductos.nombre AS nombreProducto, proveedorProductos.id AS idProducto  FROM proveedores INNER JOIN proveedorProductos WHERE proveedores.id = proveedorProductos.idProveedor AND proveedores.grupo='$id_producto'  ORDER BY proveedorProductos.nombre";
	$resultado=$mysqli->query($query);
	
	while($row = $resultado->fetch_assoc())
	{
		$html.= "<option value='".$row['idProducto']."'>".$row['nombreProducto']."</option>";
	}
	echo $html;
?>