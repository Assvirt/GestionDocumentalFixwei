<?php
	require ('conexion/bd.php');

	if(isset($_POST['rad_cargo'])){
	     $acentos = $mysqli->query("SET NAMES 'utf8'");
	    $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	    
	    $html= "";
	 
	    while($cargo = $cargos->fetch_assoc()){
    	    $html.= "<option value='".$cargo['id_cargos']."'>".$cargo['nombreCargos']."</option>";
	    }
	    echo $html;
	}
	
	if(isset($_POST['rad_usuario'])){
	     $acentos = $mysqli->query("SET NAMES 'utf8'");
	    $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	    
	    $html= "";
	    
	    while($usuario = $usuarios->fetch_assoc()){
	        $html.= "<option value='".$usuario['id']."'>".$usuario['nombres']." ".$usuario['apellidos']."</option>";
	    }
	    echo $html;
	}
	if(isset($_POST['rad_grupo'])){
	    $acentos = $mysqli->query("SET NAMES 'utf8'");
	    $grupos = $mysqli->query("SELECT id, nombre FROM grupo")or die(mysqli_error($mysqli));
	    
	    $html= "";
	    
	    while($grupo = $grupos->fetch_assoc()){
	        $html.= "<option value='".$grupo['id']."'>".$grupo['nombre']."</option>";
	    }
	    echo $html;
	}
	
	

?>