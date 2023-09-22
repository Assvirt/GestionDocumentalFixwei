<?php
	///Este documento ayuda a precargar lo multiples select del front de actas
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
	
	
	//Cita
	if(isset($_POST['radEncargado'])){
	    
	    $idActa = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargo'){
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT quienCitaID FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['quienCitaID']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT quienCitaID FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['quienCitaID']);
	    
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
	
	//Elabora
	if(isset($_POST['radEncargadoR'])){
	    
	    $idActa = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargo'){
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT quienElaboraID FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['quienElaboraID']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT quienElaboraID FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['quienElaboraID']);
	    
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
	
	//Convocados
	if(isset($_POST['radEncargadoC'])){
	    
	    $idActa = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargo'){
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT convocadoID FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['convocadoID']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT convocadoID FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['convocadoID']);
	    
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
	
	//Asistente
	if(isset($_POST['radEncargadoA'])){
	    
	    $idActa = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargo'){
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT asistenteID FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['asistenteID']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT asistenteID FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['asistenteID']);
	    
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
	
	//Compromisos
	if(isset($_POST['radEncargadoAR'])){
	    
	    $idActa = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargo'){
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT quienCitaID FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['quienCitaID']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT compromisosID FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['compromisosID']);
	    
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
	
	//Acta abierta al publico
	if(isset($_POST['radEncargadoA2'])){
	    
	    $idActa = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargo'){
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT responsablesActa FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['responsablesActa']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT responsablesActa FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['responsablesActa']);
	    
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
	    
	    if($grupo == 'grupo'){
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $grupos = $mysqli->query("SELECT id, nombre FROM grupo")or die(mysqli_error($mysqli));
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $queryDoc = $mysqli->query("SELECT responsablesActa FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['responsablesActa']);
	    
    	    $html= "";
    	    
    	    while($grupo = $grupos->fetch_assoc()){
    	        
    	        if(in_array($grupo['id'],$ArrayE)){
                    $seleccionarCarg = "selected";        
                }else{
                    $seleccionarCarg ="";
                }
    	        
    	        $html.= "<option value='".$grupo['id']."' $seleccionarCarg>".$grupo['nombre']."</option>";
    	    }
    	    
    	    echo $html;
	        
	    }
	    
	    
	    
	}
	
	
	//Para quien esta abierta el acta 
	if(isset($_POST['radEncargadoActa'])){
	    
	    $idActa = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargo'){
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT quienApruebaId FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['quienApruebaId']);
            
	    
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
	        $usuarios = $mysqli->query("SELECT id, nombres, apellidos FROM usuario")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT quienApruebaId FROM actas WHERE id = $idActa")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['quienApruebaId']);
	    
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
	
	//Esta logica es para el select de carga de registros 
	if(isset($_POST['aprobadorRegistros'])){
	    
	    $idRegistro = $_POST['rad_post'];
	    $grupo = $_POST['grupo'];
	    
	    
	    if($grupo == 'cargos'){
	         $acentos = $mysqli->query("SET NAMES 'utf8'");
	        $cargos = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos")or die(mysqli_error($mysqli));
	        
	        $queryDoc = $mysqli->query("SELECT aprobadorID FROM registros WHERE id = '$idRegistro'")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['aprobadorID']);
            
	    
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
	        
	        $queryDoc = $mysqli->query("SELECT aprobadorID FROM registros WHERE id = $idRegistro")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            $ArrayE = json_decode($datosDoc['aprobadorID']);
	    
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