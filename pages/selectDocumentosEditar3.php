<?php
	require ('conexion/bd.php');


	//////////// editar el responsable
	if(isset($_POST['radEncargado'])){
	    
	    $idPresupuesto = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargo'){
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos ORDER BY nombreCargos ASC")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT * FROM politicas WHERE id = $idPresupuesto")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['aprobador']);
            
	    
    	    $html= "";
    	 
    	    while($cargo = $cargos->fetch_assoc()){
    	        
    	        if(in_array($cargo['id_cargos'],$ArrayE)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
        	    $html.= "<option value='".$cargo['id_cargos']."' $seleccionarCarg>".$cargo['nombreCargos']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	    if($grupo == 'usuario'){
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario ORDER BY nombres ASC")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT * FROM politicas WHERE id = $idPresupuesto")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['aprobador']);
	    
    	    $html= "";
    	    
    	    while($usuario = $usuarios->fetch_assoc()){
    	        
    	        if(in_array($usuario['id'],$ArrayE)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
    	        $html.= "<option value='".$usuario['id']."' $seleccionarCarg>".$usuario['nombres']." ".$usuario['apellidos']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	}
	
	

?>