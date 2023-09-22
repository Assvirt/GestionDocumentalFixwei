<?php
	require ('conexion/bd.php');
	//$cedi = $_POST['cedi'];
	
	$resultado = $mysqli->query("SELECT DISTINCT(proceso) FROM documento ORDER BY id");
	
	
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>select dinamico</title>
		
		<script language="javascript" src="js/jquery-3.4.1.min.js"></script>
		
	
		
	</head>
	 
	<body>
		<form id="combo" name="combo" action="guarda.php" method="POST">
			<div>Selecciona Proceso : <select  name="cbx_cedi" id="cbx_cedi">
				<option value="0">Seleccionar Proceso</option>
				<?php while($row = $resultado->fetch_assoc()) { 
				$resultado2=$mysqli->query("SELECT nombre FROM procesos where id = '".$row['proceso']."'ORDER BY id");
				$col = $resultado2->fetch_array(MYSQLI_ASSOC);
				$nombreP = $col['nombre'];
				?>
				    
				
					<option value="<?php echo $row['proceso']; ?>"><?php echo $nombreP; ?></option>
				<?php } 
				?>
				
			</select></div>
			
			<br />
			
			<div>Selecciona Tipo Documento: <select  name="cbx_bodega" id="cbx_bodega"></select></div>
			
			<br />
			
			<div>Selecciona Documento: <select name="cbx_posicion" id="cbx_posicion"></select></div>
			
			<br />
			
		</form>
	</body>
		<script language="javascript">
			$(document).ready(function(){
				$("#cbx_cedi").change(function () {

					$('#cbx_posicion').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
					
					$("#cbx_cedi option:selected").each(function () {
						id_cedi = $(this).val();
						$.post("selectDinamico2.php", { id_cedi: id_cedi }, function(data){
							$("#cbx_bodega").html(data);
						});            
					});
				})
			});
			
			$(document).ready(function(){
				$("#cbx_bodega").change(function () {
					$("#cbx_bodega option:selected").each(function () {
						id_bodega = $(this).val();
						$.post("selectDinamico3.php", { id_bodega: id_bodega, id_cedi: id_cedi }, function(data){
							$("#cbx_posicion").html(data);
						});           
					});
				})
			});
		</script>
</html>