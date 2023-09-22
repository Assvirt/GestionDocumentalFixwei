<?php
	require ('conexion/bd.php');

	if(isset($_POST['rad_cargo'])){
	    $acentos = $mysqli->query("SET NAMES 'utf8'");
	    $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos ORDER BY nombreCargos ASC")or die(mysqli_error($mysqli));
	    
	    $html= "";
	 
	    while($cargo = $cargos->fetch_assoc()){
    	    $html.= "<option value='".$cargo['id_cargos']."'>".$cargo['nombreCargos']."</option>";
	    }
	    echo $html;
	}
	
	if(isset($_POST['rad_usuario'])){
	    $acentos = $mysqli->query("SET NAMES 'utf8'");
	    $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario ORDER BY nombres ASC")or die(mysqli_error($mysqli));
	    
	    $html= "";
	    
	    while($usuario = $usuarios->fetch_assoc()){
	        $html.= "<option value='".$usuario['id']."'>".$usuario['nombres']." ".$usuario['apellidos']."</option>";
	    }
	    echo $html;
	}
	
	if(isset($_POST['radEncargado'])){
	    
	    $idDocumento = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargos'){
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos ORDER BY nombreCargos ASC")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT elaboraElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['elaboraElimanar']);
            
	    
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
	    
	    if($grupo == 'usuarios'){
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario ORDER BY nombres ASC")or die(mysqli_error($mysqli));
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT elaboraElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['elaboraElimanar']);
	    
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
	
	if(isset($_POST['radRevisar'])){
	    
	    $idDocumento = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    if($grupo == 'cargos'){
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos ORDER BY nombreCargos ASC")or die(mysqli_error($mysqli));
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT revisaElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayR = json_decode($datosDoc['revisaElimanar']);
            
	    
    	    $html= "";
    	 
    	    while($cargo = $cargos->fetch_assoc()){
    	        
    	        if(in_array($cargo['id_cargos'],$ArrayR)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
        	    $html.= "<option value='".$cargo['id_cargos']."' $seleccionarCarg>".$cargo['nombreCargos']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	    if($grupo == 'usuarios'){
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT revisaElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayR = json_decode($datosDoc['revisaElimanar']);
	    
    	    $html= "";
    	    
    	    while($usuario = $usuarios->fetch_assoc()){
    	        
    	        if(in_array($usuario['id'],$ArrayR)){
                    $seleccionarUser = "selected";        
                }else{
                    $seleccionarUser ="";
                }
    	        
    	        $html.= "<option value='".$usuario['id']."' $seleccionarUser>".$usuario['nombres']." ".$usuario['apellidos']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	}
	
	if(isset($_POST['radAprobar'])){
	    
	    $idDocumento = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargos'){
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT apruebaElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['apruebaElimanar']);
            
	    
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
	    
	    if($grupo == 'usuarios'){
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT apruebaElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayA = json_decode($datosDoc['apruebaElimanar']);
	    
    	    $html= "";
    	    
    	    while($usuario = $usuarios->fetch_assoc()){
    	        
    	        if(in_array($usuario['id'],$ArrayA)){
                    $seleccionarUser = "selected";        
                }else{
                    $seleccionarUser ="";
                }
    	        
    	        $html.= "<option value='".$usuario['id']."' $seleccionarUser>".$usuario['nombres']." ".$usuario['apellidos']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	}
	

	

?>