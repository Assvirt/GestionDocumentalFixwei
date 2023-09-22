<?php
	require ('conexion/bd.php');

	if(isset($_POST['rad_cargo'])){
	    
	    $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos ORDER BY nombreCargos ASC")or die(mysqli_error($mysqli));
	    
	    $html= "";
	 
	    while($cargo = $cargos->fetch_assoc()){
    	    $html.= "<option value='".$cargo['id_cargos']."'>".$cargo['nombreCargos']."</option>";
	    }
	    echo $html;
	}
	
	if(isset($_POST['rad_usuario'])){
	    
	    $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario ORDER BY nombres ASC")or die(mysqli_error($mysqli));
	    
	    $html= "";
	    
	    while($usuario = $usuarios->fetch_assoc()){
	        $html.= "<option value='".$usuario['id']."'>".$usuario['nombres']." ".$usuario['apellidos']."</option>";
	    }
	    echo $html;
	}
	
	
	//////////// editar el responsable
	if(isset($_POST['radEncargado'])){
	    
	    $idPresupuesto = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargo'){
	        
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos ORDER BY nombreCargos ASC")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT responsable FROM presupuestoGestionar WHERE id = $idPresupuesto")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['responsable']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario ORDER BY nombres ASC")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT responsable FROM presupuestoGestionar WHERE id = $idPresupuesto")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['responsable']);
	    
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
	        
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos ORDER BY nombreCargos ASC")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT revisa FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayR = json_decode($datosDoc['revisa']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT revisa FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayR = json_decode($datosDoc['revisa']);
	    
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
	        
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT aprueba FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['aprueba']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT aprueba FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayA = json_decode($datosDoc['aprueba']);
	    
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
	
	///Encargado disposicion documental 
	if(isset($_POST['radEncargadoDD'])){
	    
	    $idDocumento = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargos'){
	        
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT responsable_disposicion FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayED = json_decode($datosDoc['responsable_disposicion']);
            
	    
    	    $html= "<option checked>CARGOS</option>";
    	 
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT responsable_disposicion FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayED = json_decode($datosDoc['responsable_disposicion']);
	    
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
	
	if(isset($_POST['radencargadoAR'])){
	    
	    $idDocumento = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargos'){
	        
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT usuario_aprovacion_reg FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayAR = json_decode($datosDoc['usuario_aprovacion_reg']);
            
	    
    	    $html= "";
    	 
    	    while($cargo = $cargos->fetch_assoc()){
    	        
    	        if(in_array($cargo['id_cargos'],$ArrayAR)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
        	    $html.= "<option value='".$cargo['id_cargos']."' $seleccionarCarg>".$cargo['nombreCargos']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	    if($grupo == 'usuarios'){
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT usuario_aprovacion_reg FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayAR = json_decode($datosDoc['usuario_aprovacion_reg']);
	    
    	    $html= "";
    	    
    	    while($usuario = $usuarios->fetch_assoc()){
    	        
    	        if(in_array($usuario['id'],$ArrayAR)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
    	        $html.= "<option value='".$usuario['id']."' $seleccionarCarg>".$usuario['nombres']." ".$usuario['apellidos']."</option>";
    	    }
    	    echo $html;
	        
	    }
	    
	}
	
	//Responsable compromiso
	if(isset($_POST['radEncargadoCom'])){
	    
	    $idCompromiso = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargo'){
	        
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT responsableID FROM compromisos WHERE id = '$idCompromiso'")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['responsableID']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT responsableID FROM compromisos WHERE id = $idCompromiso")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['responsableID']);
	    
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
	
	//A quien se entrega el compromiso
	if(isset($_POST['radEntregaA'])){
	    
	    $idCompromiso = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargo'){
	        
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT entregarAID FROM compromisos WHERE id = '$idCompromiso'")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['entregarAID']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT entregarAID FROM compromisos WHERE id = $idCompromiso")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['entregarAID']);
	    
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