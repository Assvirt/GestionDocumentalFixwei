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
	

	//// para traer los id seleccionados de la creación pero para editar

	if(isset($_POST['responsableDisposicion'])){
		
	    
	    $idDocumento = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargos'){
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos ORDER BY nombreCargos ASC")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT responsable_disposicion FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['responsable_disposicion']);
            
	    
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
	        $queryDoc = $mysqli->query("SELECT responsable_disposicion FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['responsable_disposicion']);
	    
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
	//END


	//// para traer los id seleccionados en el actualizar
	if(isset($_POST['radEncargado'])){
	    
	    $idDocumento = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargos'){
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos ORDER BY nombreCargos ASC")or die(mysqli_error($mysqli));
	        
	       
            
            
            if($_POST['idSolicitudDocumento'] == 1){
                 $queryDoc = $mysqli->query("SELECT elabora FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['elabora']);
            }elseif($_POST['idSolicitudDocumento'] == 2){
                 $queryDoc = $mysqli->query("SELECT elaboraActualizar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['elaboraActualizar']);
            }elseif($_POST['idSolicitudDocumento'] == 3){
                 $queryDoc = $mysqli->query("SELECT elaboraElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['elaboraElimanar']);
            }
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
	        
	        
	        /*
	        $queryDoc = $mysqli->query("SELECT elaboraActualizar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['elaboraActualizar']);
	        */
	        
	        if($_POST['idSolicitudDocumento'] == 1){
                 $queryDoc = $mysqli->query("SELECT elabora FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['elabora']);
            }elseif($_POST['idSolicitudDocumento'] == 2){
                 $queryDoc = $mysqli->query("SELECT elaboraActualizar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['elaboraActualizar']);
            }elseif($_POST['idSolicitudDocumento'] == 3){
                 $queryDoc = $mysqli->query("SELECT elaboraElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['elaboraElimanar']);
            }
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
	        /*$acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT revisaActualizar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayR = json_decode($datosDoc['revisaActualizar']);*/
            
            if($_POST['idSolicitudDocumento'] == 1){
                 $queryDoc = $mysqli->query("SELECT revisa FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayR = json_decode($datosDoc['revisa']);
            }elseif($_POST['idSolicitudDocumento'] == 2){
                 $queryDoc = $mysqli->query("SELECT revisaActualizar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayR = json_decode($datosDoc['revisaActualizar']);
            }elseif($_POST['idSolicitudDocumento'] == 3){
                 $queryDoc = $mysqli->query("SELECT revisaElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayR = json_decode($datosDoc['revisaElimanar']);
            }
	    
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
	       /*$acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT revisaActualizar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayR = json_decode($datosDoc['revisaActualizar']);*/
            
            if($_POST['idSolicitudDocumento'] == 1){
                 $queryDoc = $mysqli->query("SELECT revisa FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayR = json_decode($datosDoc['revisa']);
            }elseif($_POST['idSolicitudDocumento'] == 2){
                 $queryDoc = $mysqli->query("SELECT revisaActualizar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayR = json_decode($datosDoc['revisaActualizar']);
            }elseif($_POST['idSolicitudDocumento'] == 3){
                 $queryDoc = $mysqli->query("SELECT revisaElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayR = json_decode($datosDoc['revisaElimanar']);
            }
	    
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
	       /* $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT apruebaActualizar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['apruebaActualizar']);*/
            
            if($_POST['idSolicitudDocumento'] == 1){
                 $queryDoc = $mysqli->query("SELECT aprueba FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['aprueba']);
            }elseif($_POST['idSolicitudDocumento'] == 2){
                 $queryDoc = $mysqli->query("SELECT apruebaActualizar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['apruebaActualizar']);
            }elseif($_POST['idSolicitudDocumento'] == 3){
                 $queryDoc = $mysqli->query("SELECT apruebaElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['apruebaElimanar']);
            }
	    
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
	        /*$acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT apruebaActualizar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayA = json_decode($datosDoc['apruebaActualizar']);
            */
            
            if($_POST['idSolicitudDocumento'] == 1){
                 $queryDoc = $mysqli->query("SELECT aprueba FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['aprueba']);
            }elseif($_POST['idSolicitudDocumento'] == 2){
                 $queryDoc = $mysqli->query("SELECT apruebaActualizar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['apruebaActualizar']);
            }elseif($_POST['idSolicitudDocumento'] == 3){
                 $queryDoc = $mysqli->query("SELECT apruebaElimanar FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                 $datosDoc = $queryDoc->fetch_assoc();
                 $ArrayE = json_decode($datosDoc['apruebaElimanar']);
            }
            
            	    
    	    $html= "";
    	    
    	    while($usuario = $usuarios->fetch_assoc()){
    	        
    	        if(in_array($usuario['id'],$ArrayE)){
                    $seleccionarUser = "selected";        
                }else{
                    $seleccionarUser ="";
                }
    	        
    	        $html.= "<option value='".$usuario['id']."' $seleccionarUser>".$usuario['nombres']." ".$usuario['apellidos']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	}
	
	
	/// cuando viene por la alerta
    if(isset($_POST['envioAlertaNombre'])){
	    
	    $idDocumento = $_POST['rad_postAlerta'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargos'){
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT responsable FROM documentoDatosTemporales WHERE solicitud = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayED = json_decode($datosDoc['responsable']);
            
	    
    	    $html= ""; //<option checked>CARGOS</option>
    	 
    	    while($cargo = $cargos->fetch_assoc()){
    	        
    	        if(in_array($cargo['id_cargos'],$ArrayED)){
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
	        $queryDoc = $mysqli->query("SELECT responsable FROM documentoDatosTemporales WHERE solicitud = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayED = json_decode($datosDoc['responsable']);
	    
    	    $html= "";
    	    
    	    while($usuario = $usuarios->fetch_assoc()){
    	        
    	        if(in_array($usuario['id'],$ArrayED)){
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