<?php
	require ('conexion/bd.php');

	if(isset($_POST['rad_proceso'])){
	    
	    $cargos = $mysqli->query("SELECT id, nombre FROM procesos")or die(mysqli_error($mysqli));
	    
	    $html= "";
	 
	    while($cargo = $cargos->fetch_assoc()){
    	    $html.= "<option value='".$cargo['id']."'>".$cargo['nombre']."</option>";
	    }
	    echo $html;
	}
	
	if(isset($_POST['rad_centro'])){
	    
	    $usuarios = $mysqli->query("SELECT id, nombre FROM centroCostos")or die(mysqli_error($mysqli));
	    
	    $html= "";
	    
	    while($usuario = $usuarios->fetch_assoc()){
	        $html.= "<option value='".$usuario['id']."'>".$usuario['nombre']."</option>";
	    }
	    echo $html;
	}
	
	
//////////// editar los procesos o los entros de costo
	if(isset($_POST['radEncargadoP'])){
	    
	    $idPresupuesto = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'proceso'){
	        
	        $cargos = $mysqli->query("SELECT id, nombre FROM procesos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE id = $idPresupuesto")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['procesoCosto']);
            
	    
    	    $html= "";
    	 
    	    while($cargo = $cargos->fetch_assoc()){
    	        
    	        if(in_array($cargo['id'],$ArrayE)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
        	    $html.= "<option value='".$cargo['id']."' $seleccionarCarg>".$cargo['nombre']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	    if($grupo == 'centroCosto'){
	        $usuarios = $mysqli->query("SELECT id, nombre FROM centroCostos")or die(mysqli_error($mysqli));
	        
	        $queryDoc2 = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE id = $idPresupuesto")or die(mysqli_error($mysqli));
            $datosDoc2 = $queryDoc2->fetch_assoc();
            $ArrayE = json_decode($datosDoc2['procesoCosto']);
	    
    	    $html= "";
    	    
    	    while($usuario = $usuarios->fetch_assoc()){
    	        
    	        if(in_array($usuario['id'],$ArrayE)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
    	        $html.= "<option value='".$usuario['id']."' $seleccionarCarg>".$usuario['nombre']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	}	

?>