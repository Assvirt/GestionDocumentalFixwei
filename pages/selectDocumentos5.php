<?php
	require ('conexion/bd.php');

	if(isset($_POST['rad_costo'])){
	    $idPresupuesto=$_POST['idPresupuesto'];
	    $cargos = $mysqli->query("SELECT id, nombreGC FROM presupuestoGrupos WHERE modulo='grupo' AND idPresupesto='$idPresupuesto' ")or die(mysqli_error($mysqli));
	    
	    $html= "";
	 
	    while($cargo = $cargos->fetch_assoc()){
    	    $html.= "<option value='".$cargo['id']."'>".$cargo['nombreGC']."</option>";
	    }
	    echo $html;
	}
	if(isset($_POST['rad_costoS'])){
	    $idPresupuesto=$_POST['idPresupuesto'];
	    $cargos = $mysqli->query("SELECT id, nombreSGC FROM presupuestoGrupos WHERE modulo='subgrupo' AND idPresupesto='$idPresupuesto' ")or die(mysqli_error($mysqli));
	    
	    $html= "";
	 
	    while($cargo = $cargos->fetch_assoc()){
    	    $html.= "<option value='".$cargo['id']."'>".$cargo['nombreSGC']."</option>";
	    }
	    echo $html;
	}

//////////// editar los procesos o los entros de costo
	if(isset($_POST['radEncargadoPC'])){
	    
	    $idPresupuesto = $_POST['rad_post'];
	    $idPresupuestoGestionar = $_POST['rad_Gestionar'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'costo'){
	        
	        $cargos = $mysqli->query("SELECT id, nombreGC FROM presupuestoGrupos WHERE modulo='grupo' AND idPresupesto='$idPresupuesto' ")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT * FROM presupuestoGestionar  WHERE id = '$idPresupuestoGestionar' ")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['CostoGastoGrupo']);
            
	    
    	    $html= "";
    	 
    	    while($cargo = $cargos->fetch_assoc()){
    	        
    	        if(in_array($cargo['id'],$ArrayE)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
        	    $html.= "<option value='".$cargo['id']."' $seleccionarCarg>".$cargo['nombreGC']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	    if($grupo == 'gasto'){
	        $usuarios = $mysqli->query("SELECT id, nombreGC FROM presupuestoGruposGastos WHERE modulo='grupo' AND idPresupesto='$idPresupuesto'")or die(mysqli_error($mysqli));
	        
	        $queryDoc2 = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE id = $idPresupuestoGestionar ")or die(mysqli_error($mysqli));
            $datosDoc2 = $queryDoc2->fetch_assoc();
            $ArrayE = json_decode($datosDoc2['CostoGastoGrupo']);
	    
    	    $html= "";
    	    
    	    while($usuario = $usuarios->fetch_assoc()){
    	        
    	        if(in_array($usuario['id'],$ArrayE)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
    	        $html.= "<option value='".$usuario['id']."' $seleccionarCarg>".$usuario['nombreGC']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	}
	
	//////////// editar los procesos o los entros de costo
	if(isset($_POST['radEncargadoPCS'])){
	    
	    $idPresupuesto = $_POST['rad_post'];
	    $idPresupuestoGestionar = $_POST['rad_Gestionar'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'costo'){
	        
	        $cargos = $mysqli->query("SELECT id, nombreSGC FROM presupuestoGrupos WHERE modulo='subgrupo' AND idPresupesto='$idPresupuesto' ")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT * FROM presupuestoGestionar  WHERE id = '$idPresupuestoGestionar' ")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['CostoGastoSubgrupo']);
            
	    
    	    $html= "";
    	 
    	    while($cargo = $cargos->fetch_assoc()){
    	        
    	        if(in_array($cargo['id'],$ArrayE)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
        	    $html.= "<option value='".$cargo['id']."' $seleccionarCarg>".$cargo['nombreSGC']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	    if($grupo == 'gasto'){
	        $usuarios = $mysqli->query("SELECT id, nombreSGC FROM presupuestoGruposGastos WHERE modulo='subgrupo' AND idPresupesto='$idPresupuesto'")or die(mysqli_error($mysqli));
	        
	        $queryDoc2 = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE id = $idPresupuestoGestionar ")or die(mysqli_error($mysqli));
            $datosDoc2 = $queryDoc2->fetch_assoc();
            $ArrayE = json_decode($datosDoc2['CostoGastoSubgrupo']);
	    
    	    $html= "";
    	    
    	    while($usuario = $usuarios->fetch_assoc()){
    	        
    	        if(in_array($usuario['id'],$ArrayE)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
    	        $html.= "<option value='".$usuario['id']."' $seleccionarCarg>".$usuario['nombreSGC']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	}
	
	

	
	

///////////////////////////////////// hasta acá llega las validaciones para los costos y empiezan para los gastos
	
	
	
	if(isset($_POST['rad_gasto'])){
	    $idPresupuesto=$_POST['idPresupuesto'];
	    $usuarios = $mysqli->query("SELECT id, nombreGC FROM presupuestoGruposGastos WHERE modulo='grupo' AND idPresupesto='$idPresupuesto' ")or die(mysqli_error($mysqli));
	    
	    $html= "";
	    
	    while($usuario = $usuarios->fetch_assoc()){
	        $html.= "<option value='".$usuario['id']."'>".$usuario['nombreGC']."</option>";
	    }
	    echo $html;
	}
	
	if(isset($_POST['rad_gastoS'])){
	    $idPresupuesto=$_POST['idPresupuesto'];
	    $usuarios = $mysqli->query("SELECT id, nombreSGC FROM presupuestoGruposGastos WHERE modulo='subgrupo' AND idPresupesto='$idPresupuesto' ")or die(mysqli_error($mysqli));
	    
	    $html= "";
	    
	    while($usuario = $usuarios->fetch_assoc()){
	        $html.= "<option value='".$usuario['id']."'>".$usuario['nombreSGC']."</option>";
	    }
	    echo $html;
	}
	




?>