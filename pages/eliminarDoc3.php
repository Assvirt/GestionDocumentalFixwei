<?php error_reporting(E_ERROR);
session_start();
date_default_timezone_set("America/Bogota");
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';

    $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = '".$_POST['idDocumento']."'")or die(mysqli_error($mysqli));
    $datosDoc = $queryDoc->fetch_assoc();
    $idUsuario = $_SESSION['session_idUsuario'];
    if($datosDoc['asumeFlujo'] == $idUsuario){//sE VALIDA QUE SEA EL USUARIO QUE TOMO PRIMERO LA SOLICITUD. 
        

    }else{ 
        if($datosDoc['asumeFlujo'] == NULL){
        ?>    
            <script> 
                 window.onload=function(){
               
                     document.forms["sacarDelFlujo"].submit();
                 }
                 setTimeout(clickbuttonScarFlujo, 0999);
                 function clickbuttonScarFlujo() { 
                    document.forms["sacarDelFlujo"].submit();
                 }
            </script>
             
            <form name="sacarDelFlujo" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                <input type="hidden" name="validacionUsuario2" value="1">
            </form>
    <?php    
        }else{
    ?>    
            <script> 
                 window.onload=function(){
               
                     document.forms["sacarDelFlujo"].submit();
                 }
                 setTimeout(clickbuttonScarFlujo, 1000);
                 function clickbuttonScarFlujo() { 
                    document.forms["sacarDelFlujo"].submit();
                 }
            </script>
             
            <form name="sacarDelFlujo" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="idDocumento" value="<?php echo $_POST['idDocumento'];?>">
                <input type="hidden" name="validacionUsuario" value="1">
            </form>
    <?php  
        }
     
    }
    
    
    //$rolFlujo = $_POST['rol'];
    $idDocumento = $_POST['idDocumento'];
    $nombreDoc = $_POST['nombreDocumento'];
    $norma = $_POST['norma'];
    $proceso = $_POST['proceso'];
    $metodo = $_POST['rad_metodo'];
    $tipoDoc = $_POST['tipoDoc'];
    $ubicacion = $_POST['ubicacion'];
    $elabora = $_POST['select_encargadoE'];
    $revisa = $_POST['select_encargadoR'];
    $aprueba = $_POST['select_encargadoA'];
    

    $html = htmlentities($_POST['editor1']);
    
    $nombrePDF =$_FILES['archivopdf']['name']; 
    $rutaPDF =$_FILES['archivopdf']['tmp_name']; 
    $nombreOtro =$_FILES['archivootro']['name'];
    $rutaOtro =$_FILES['archivootro']['tmp_name'];
    
    $documetosExternos = $_POST['documentos_externos'];
    $definiciones = $_POST['definiciones'];
    
    $archivo_gestion = $_POST['archivo_gestion']; 
    $archivo_central = $_POST['archivo_central']; 
    $archivo_historico = $_POST['archivo_historico']; 
    
    $diposicion_documental = $_POST['diposicion_documental'];
    $select_encargadoD = $_POST['select_encargadoD'];
    $radDispoDoc = $_POST['radiobtnD'];

    $fecha = date("Ymjhis");

    $radElabora = $_POST['radiobtnE'];
    $radRevisa = $_POST['radiobtnR'];
    $radAprueba = $_POST['radiobtnA'];
    
    $acentos = $mysqli->query("SET NAMES 'utf8'");
    $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
    $datosDoc = $queryDoc->fetch_assoc();

    if(!file_exists('archivos/documentos/')){
    	mkdir('archivos/documentos',0777,true);
    	if(file_exists('archivos/documentos/')){
    		if(move_uploaded_file($rutaPDF, 'archivos/documentos/'.$fecha.$nombrePDF)){
    			
    		}else{
    			//echo "Archivo no se pudo guardar";
    		}
    	}
    }else{
    	if(move_uploaded_file($rutaPDF, 'archivos/documentos/'.$fecha.$nombrePDF)){
    	
    	}else{
    		//echo "Archivo no se pudo guardar";
    	}
    }
    
    if(!file_exists('archivos/documentos/')){
    	mkdir('archivos/documentos',0777,true);
    	if(file_exists('archivos/documentos/')){
    		if(move_uploaded_file($rutaOtro, 'archivos/documentos/'.$fecha.$nombreOtro)){
    			//echo "Archivo guardado con exito";
    			
    		}else{
    			//echo "Archivo no se pudo guardar";
    		}
    	}
    }else{
    	if(move_uploaded_file($rutaOtro, 'archivos/documentos/'.$fecha.$nombreOtro)){
    		//echo "Archivo guardado con exito";
    	}else{
    		//echo "Archivo no se pudo guardar";
    	}
    }
    
    if($datosDoc['estadoElimina'] == NULL || $datosDoc['estadoEliminar'] == ''){
        $rolFlujo = "Encargado(a) solicitud"; 
    }
    
    if($datosDoc['estadoElimina'] == "Pendiente"){
        $rolFlujo = "Elaborador(a)";
    }
    
    if($datosDoc['estadoElimina'] == "Elaborado"){
        $rolFlujo = "Revisor(a)";
    }
    
    if($datosDoc['estadoElimina'] == "Revisado"){
        $rolFlujo = "Aprobador(a)";
    }
    
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Revisar documento</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini" oncopy="return false" onpaste="return false" onload="nobackbutton();">
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
                         <?php
            /// de acuerdo al rol de la persona cambia el título
            $elaboraValidacion = json_decode($datosDoc['elaboraElimanar']);
            $revisaValidacion = json_decode($datosDoc['revisaElimanar']);
            $apruebaValidacion = json_decode($datosDoc['apruebaElimanar']);
            
           
            ///////////////////////////// para el elaborador
                if($elaboraValidacion[0] == 'usuarios'){
                    $longitudValidacion = count($elaboraValidacion);
                                                        
                    for($i=1; $i<$longitudValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$elaboraValidacion[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	//$variableValidado=$nombres['id'];
                    	if($idparaChat == $elaboraValidacion[$i]){                                    
                    	    $variableValidado=$nombres['id'];
                        }else{
                            continue;
                        }  
                    } 
                }
                elseif($elaboraValidacion[0] == 'cargos'){
                    $longitudCValidacion = count($elaboraValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$elaboraValidacion[$i]' AND id='$idparaChat' ");
                        while($nombres = $queryNombres->fetch_array()){ 
                                                            
                    	$variableValidado=$nombres['id'];
                        }
                    } 
                }
            
            /////////////////////////////// para el revisor
                if($revisaValidacion[0] == 'usuarios'){
                    $longitudBValidacion = count($revisaValidacion);
                                                        
                    for($i=1; $i<$longitudBValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$revisaValidacion[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	//$variableValidadoB=$nombres['id'];
                    	if($idparaChat == $revisaValidacion[$i]){                                    
                    	    $variableValidadoB=$nombres['id'];
                        }else{
                            continue;
                        }
                    } 
                }elseif($revisaValidacion[0] == 'cargos'){
                    $longitudCValidacion = count($revisaValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$revisaValidacion[$i]' AND id='$idparaChat' ");
                        while($nombres = $queryNombres->fetch_array()){ 
                                                            
                    	$variableValidadoB=$nombres['id'];
                        }
                    } 
                }
            
            
            ////////////////////////////// para el aprobador
                if($apruebaValidacion[0] == 'usuarios'){
                    $longitudCValidacion = count($apruebaValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$apruebaValidacion[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	//$variableValidadoC=$nombres['id'];
                    	if($idparaChat == $apruebaValidacion[$i]){                                    
                    	    $variableValidadoC=$nombres['id'];
                        }else{
                            continue;
                        } 
                    } 
                }elseif($apruebaValidacion[0] == 'cargos'){
                    $longitudCValidacion = count($apruebaValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$apruebaValidacion[$i]' AND id='$idparaChat' ");
                        while($nombres = $queryNombres->fetch_array()){ 
                                                            
                    	$variableValidadoC=$nombres['id'];
                        }
                    } 
                }
                
                
            /*    
            if($variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == null || $datosDoc['estadoElimina'] == 'Pendiente'){
                $títulRol='Crear documento';
            }elseif($variableValidadoB == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == 'Elaborado'){ 
                $títulRol='Revisar documento';
            }elseif($variableValidadoC == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == 'Revisado'){ 
                $títulRol='Aprobar documento';
            }else{ $VariableNoSalir=1;
                $títulRol='Asignar documento';
            }*/
             // consultamos el usuario de la sesión para verificar que tenga el mismo cargo para la aprobación del documento
            $celdulaUser = $_SESSION['session_username']; 
            $query_busqueda_cargo = $mysqli->query("SELECT  cedula,cargo FROM usuario WHERE cedula = '$celdulaUser'");
            $nombres_busqueda_cargo = $query_busqueda_cargo->fetch_array(MYSQLI_ASSOC);
            
            $enviar_id_solicitud=$datosDoc['id_solicitud'];
            /// traemos el cargo asociado que está en la solicitud
            $query_busqueda_cargo_solicitud = $mysqli->query("SELECT  * FROM solicitudDocumentos WHERE id = '$enviar_id_solicitud'");
            $nombres_busqueda_cargo_solicitud = $query_busqueda_cargo_solicitud->fetch_array(MYSQLI_ASSOC);
            
             '<br> quien aprieba: '.$nombres_busqueda_cargo_solicitud['QuienAprueba'];
            ' - '.$nombres_busqueda_cargo['cargo'];
            
                
            if($variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == null || $variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == 'Pendiente'){
                $títulRol='Crear documento';
                $activador_usuario='Si';
            }elseif($variableValidadoB == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == 'Elaborado'){ 
                $títulRol='Revisar documento';
                $activador_usuario='Si';
            }elseif($variableValidadoC == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == 'Revisado'){ 
                $títulRol='Aprobar documento';
                $activador_usuario='Si';
            }else{ /// verificamos que los roles estén ingresando, tmabién verificamos que el encargado que es el aprobador, sea quien tenga el documento abierto
                if($activador_usuario != NULL){ //echo 'a 1';
                    $títulRol='Asignar documento';
                }elseif($nombres_busqueda_cargo_solicitud['QuienAprueba'] == $celdulaUser && $datosDoc['estadoElimina'] == null || $nombres_busqueda_cargo_solicitud['QuienAprueba'] == $celdulaUser && $datosDoc['estadoElimina'] == 'Pendiente'){ //echo 'a 2';
                    $títulRol='Asignar documento';
                }else{
                    $títulRol==NULL;
                }
            }
             
             if($títulRol == NULL){
                 //echo 'Campo vacio';
                // $update = $mysqli->query("UPDATE documento SET asumeFlujo = null WHERE id = '$idDocumento' ");
                 ?>
                    <script> 
                         window.onload=function(){
                            // document.forms["documentoValidarSinEstado"].submit();
                         }
                         setTimeout(clickbuttonArchivoPerfil, 2000);
                         function clickbuttonArchivoPerfil() { 
                            document.forms["documentoValidarSinEstado"].submit();
                         }
                    </script>
                     
                    <form name="documentoValidarSinEstado" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                        <input value="1" name="alertaSinMensaje" type="hidden">
                    </form>
                <?php
             }
             
            ?>
            <h1><?php echo $títulRol;?></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active"><?php echo $títulRol;?></li>
            </ol>
          </div>
        </div>
        <!--<div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-success btn-sm"><a href="crearDocumento2"><font color="white"><i class="fas fa-chevron-left"></i> Regresar</font></a></button>
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                </div>
            </div>
            <div class="col">
            </div>   
        </div>-->
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"> </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/documentos/controllerEliminar" method="POST"  onsubmit="return checkSubmit();">
                <div class="card-body">
                    <div class="row">
                        <?php
                            $encaAprova = json_decode($datosDoc['usuario_aprovacion_reg']);
                            
                            if($encaAprova != NULL){
                                $checkedSi = "checked";
                            }else{
                                $checkedNo = "checked";
                            }
                        ?>
                        

                        <div class="form-group col-sm-12">
                            <label>Flujo de aprobación</label>
                            <?php
                            if($VariableNoSalir == 1){}else{
                            ?>
                            <br>
                            <label>
                                <input type="radio" id="rad_flujo" name="rad_flujo" value="reinicia" required>
                                Regresa flujo de aprobación
                            </label>
                            <?php
                            }
                            ?>
                            <br>
                            <label>
                                <input type="radio" id="rad_reinicio" name="rad_flujo" value="ajusta" required>
                                Ajusta y continua flujo de aprobación
                            </label>
                            <br>
                            <label>
                                <input type="radio" id="rad_cierra" name="rad_flujo" value="cierra" required>
                                Cierra solicitud documental
                            </label>
                            
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Meses para próxima revisión</label>
                            <input name="mesesRevision" type="number" min="1" max="24" value="<?php echo $datosDoc['mesesRevision'];?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                          <div class="col-sm-12">
                               <center>
                                    <br>
                                    <p><h4>Control de Cambios</h4></p>
                                </center>
                            <?php
                            // consulta de la tabla del control de cambios
                                 'id1: '.$idDocumento;
                                
                                
                                $consultandoFlujoControlCambiosConsulta=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idDocumento' ");
                                $extraerConsultaFlujoControlCambiosConsulta=$consultandoFlujoControlCambiosConsulta->fetch_array(MYSQLI_ASSOC);
                                $consultandoExistenciaDocumentoActualizar=$extraerConsultaFlujoControlCambiosConsulta['idDocumento'];
                                
                                if($consultandoExistenciaDocumentoActualizar != NULL){
                                    // ahora sacamos la información del último control de cambio realiado
                                    /// cuando entra a la primera actualización entra a esta consulta
                                    $consultandoFlujoControlCambios=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idDocumento' ");
                                    $extraerConsultaFlujoControlCambios=$consultandoFlujoControlCambios->fetch_array(MYSQLI_ASSOC);
                                    $informacionDelTexto=$extraerConsultaFlujoControlCambios['informacion']; // sacamos el id anterior
                                }else{
                                     $consultandoDocumento=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento' ");
                                    $extraerConsultaDocumento=$consultandoDocumento->fetch_array(MYSQLI_ASSOC);
                                    'Id anterior: '.$extraerIdAnterior=$extraerConsultaDocumento['idAnterior']; // sacamos el id anterior
                                    
                                   
                                    if($extraerIdAnterior != NULL){
                                         /// cuando entra a la primera actualización entra a esta consulta
                                        $consultandoFlujoControlCambios=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$extraerIdAnterior' ");
                                        $extraerConsultaFlujoControlCambios=$consultandoFlujoControlCambios->fetch_array(MYSQLI_ASSOC);
                                        $informacionDelTexto=$extraerConsultaFlujoControlCambios['informacion']; // sacamos el id anterior
                                    }else{
                                         // end  
                                        $consultaControlCambios=$mysqli->query("SELECT * FROM  controlCambiosParametrizacion ");
                                        $extraerControlCambios=$consultaControlCambios->fetch_array(MYSQLI_ASSOC);
                                        $informacionDelTexto=$extraerControlCambios['informacion'];
                                    }
                                   
                                }
                                
                                
                            if($títulRol == 'Aprobar documento'){
                              //echo 'Respaldamos los comentarios anterior';
                               //$updateDocumento=$mysqli->query("UPDATE controlCambiosFlujo SET comentarioAnterior='$informacionDelTexto' WHERE idDocumento='$idDocumento'  ");
                            }  
                                
                            ?>
                            <input name="idAnteriorControlCambios" value="<?php echo $idDocumento;?>" type="hidden">
                            <textarea name="editor1" required><?php echo $informacionDelTexto;?></textarea>
                        </div>

                        <div class="col-sm-12">
                            <div class="card">
                                <center>
                                    <br>
                                    <p><h4>Comentarios</h4></p>
                                </center>
                                    <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                          <?php 
                                            $idSol = $datosDoc['id_solicitud'];
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idSol'")or die(mysqli_error($mysqli));
                                            
                                            while($row = $queryControl->fetch_assoc()){
                                                $idUser = $row['idUsuario'];
                                                $rol = $row['rol'];
                                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                $datosUser = $queryUser->fetch_assoc();

                                                $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                          ?>
                                          
                                          <div class="time-label">
                                            <span class="bg-danger">
                                              <?php echo substr($row['fecha'],0,-8);//echo $row['fecha']?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              
                                              <h3 class="timeline-header border-0"><b><?php echo $rol?></b> - <a href="#"><?php echo $nombreUsuario?></a> <?php echo $row['comentario']?>
                                              </h3>
                                            </div>
                                          </div>
                                        <?php }?>
                                        </div>
                                     </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group col-sm-12">
                            
                            <label>Comentarios: </label>
                            <textarea rows="2" class="form-control" name="controlCambios" placeholder="Comentarios" onkeypress="return (event.charCode == 58 || event.charCode == 59 || event.charCode == 13 || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"></textarea>
                            <br>
                            
                            <label style="display:none;" id="tituloAprobado"><input style="display:none;" type="radio" name="radiobtnAprobado" id="aprobado" value="aprobado" required> Aprobado</label>
                            <label style="display:none;" id="tituloRechazado"><input style="display:none;" type="radio" name="radiobtnAprobado" id="rechazado" value="rechazado" required> Rechazado</label>
                        
                        </div>
                    </div>
                        
        
                  <!--
                  
                  ACA SE AGREGAN ELEMENTOS NUEVOS
                  
                  SE PUEDE EXTRAER DE: 
                  https://fixwei.com/plataforma/pages/forms/general.html
                  https://fixwei.com/plataforma/pages/forms/advanced.html
                  https://fixwei.com/plataforma/pages/forms/editors.html
                  
                  -->
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <!--Envio variables ocultas-->
                    <input type="hidden" name="rol" value="<?php echo $rolFlujo;?>"> 
                    <input type="hidden" name="idDocumento" id="idDocumento" value="<?php echo $idDocumento ;?>" >
                    <input type="hidden" name="nombreDocumento" value="<?php echo $nombreDoc ;?>" >
                    <input type="hidden" name="norma" value='<?php echo $norma;?>' >
                    <input type="hidden" name="proceso" value="<?php echo $proceso ;?>" >
                    <input type="hidden" name="rad_metodo" value="<?php echo $metodo ;?>" >
                    <input type="hidden" name="tipoDoc" value="<?php echo $tipoDoc ;?>" >
                    <input type="hidden" name="ubicacion" value="<?php echo $ubicacion ;?>" >
                    <input type="hidden" name="select_encargadoE" value='<?php echo $elabora ;?>' >
                    <input type="hidden" name="select_encargadoR" value='<?php echo $revisa ;?>' >
                    <input type="hidden" name="select_encargadoA" value='<?php echo $aprueba ;?>' >
                    <input type="hidden" name="radiobtnE" value="<?php echo $radElabora; ?>">
                    <input type="hidden" name="radiobtnR" value="<?php echo $radRevisa; ?>">
                    <input type="hidden" name="radiobtnA" value="<?php echo $radAprueba; ?>">
                    <!--Datos de crearDocumento 2-->

                    <input type="hidden" name="editorHtml"  value="<?php echo $html?>" >
                    <input type="hidden" name="nombrePDF" value="<?php echo $fecha.$nombrePDF ;?>">
                    <input type="hidden" name="rutaPDF" value="<?php echo $rutaPDF ;?>">
                    <input type="hidden" name="nombreOtro" value="<?php echo $fecha.$nombreOtro ;?>">
                    <input type="hidden" name="rutaOtro" value="<?php echo $rutaOtro ;?>">
                    <input type="hidden" name="documentos_externos" value='<?php echo serialize($documetosExternos) ;?>'>
                    <input type="hidden" name="definiciones" value='<?php echo serialize($definiciones) ;?>'>
                    <input type="hidden" name="archivo_gestion" value="<?php echo $archivo_gestion ;?>">
                    <input type="hidden" name="archivo_central" value="<?php echo $archivo_central ;?>">
                    <input type="hidden" name="archivo_historico" value="<?php echo $archivo_historico ;?>">
                    <input type="hidden" name="diposicion_documental" value="<?php echo $diposicion_documental ;?>">
                    <!-- select_encargadoD: este es el encargado de la disposicion documental -->
                    <input type="hidden" name="select_encargadoD" value='<?php echo serialize($select_encargadoD);?>'>
                    <input type="hidden" name="radiobtnD" value="<?php echo $radDispoDoc; ?>">
                   <div id="habilitarBotonFinalizar" style="display:none;">      
                      <button id="validarOcultar" type="submit" name="eliminarDoc" class="btn btn-success float-right">Finalizar >></button>
                  </div>
                  <!--
                  <style>
                                .preloader {
                                    width: 70px;
                                    height: 70px;
                                    border: 10px solid #eee;
                                    border-top: 10px solid #666;
                                    border-radius: 50%;
                                    animation-name: girar;
                                    animation-duration: 2s;
                                    animation-iteration-count: infinite;
                                    animation-timing-function: linear;
                                    }
                                    @keyframes girar {
                                    from {
                                        transform: rotate(0deg);
                                    }
                                    to {
                                        transform: rotate(360deg);
                                    }
                                    }
                            </style> 
                            <div id="cargando" class="preloader float-right" style="display:none;"></div>
                            <script>
                                $(document).ready(function(){
                                    $('#validarOcultar').click(function(){
                                        document.getElementById('cargando').style.display = '';
                                        document.getElementById('validarOcultar').style.display = 'none';
                                    });
                                });
                            </script>
                            -->
                </div>
              </form>
            </div>
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php echo require_once'footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
         enviando = false; //Obligaremos a entrar el if en el primer submit
    
        function checkSubmit() {
            if (!enviando) {
        		enviando= true;
        		return true;
            } else {
                //Si llega hasta aca significa que pulsaron 2 veces el boton submit
                //alert("El formulario ya se esta enviando");
                return false;
            }
        }
</script>
<!--Ckeditor-->
<script src="ckeditor5/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<!-- jQuery -->
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<!--Oculta div-->
<script>
    $(document).ready(function(){
        $('#rad_si').click(function(){
            document.getElementById('aprovar_regitros').style.display = '';
        });
        $('#rad_no').click(function(){
            document.getElementById('aprovar_regitros').style.display = 'none';
        });
    });
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAR").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAR").html(data);
            }); 
        });
        
        
        var radios = document.getElementsByName('radiobtnReg');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          
          if (radios[i].checked) {
              if(radios[i].value == 'si'){
                 document.getElementById('aprovar_regitros').style.display = ''; 
              }
              
              if(radios[i].value == 'no'){
                 document.getElementById('aprovar_regitros').style.display = 'none'; 
              }
          }
        }
        
        
        
        var radios = document.getElementsByName('radiobtnAR');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radencargadoAR = "radencargadoAR";
            
           // alert(rad_post);
            
            $.post("selectDocumentos2.php", { rad_post: rad_post, grupo: grupo, radencargadoAR: radencargadoAR}, function(data){
                $("#select_encargadoAR").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
        
        
        
    });
</script>
<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1' );
</script>
 <script>
            $(document).ready(function(){
                $('#rad_flujo').click(function(){
                    document.getElementById('aprobado').style.display = 'none';
                    document.getElementById('rechazado').style.display = '';
                    document.getElementById('tituloRechazado').style.display = '';
                    document.getElementById('tituloAprobado').style.display = 'none';
                    document.getElementById('habilitarBotonFinalizar').style.display = '';
                });
            });
            $(document).ready(function(){
                $('#rad_reinicio').click(function(){
                    document.getElementById('aprobado').style.display = '';
                    document.getElementById('rechazado').style.display = 'none';
                    document.getElementById('tituloRechazado').style.display = 'none';
                    document.getElementById('tituloAprobado').style.display = '';
                    document.getElementById('habilitarBotonFinalizar').style.display = '';
                });
            
            });
            $(document).ready(function(){
                $('#rad_cierra').click(function(){
                    document.getElementById('aprobado').style.display = 'none';
                    document.getElementById('rechazado').style.display = '';
                    document.getElementById('tituloRechazado').style.display = '';
                    document.getElementById('tituloAprobado').style.display = 'none';
                    document.getElementById('habilitarBotonFinalizar').style.display = '';
                });
            
            });
        </script>
</body>
</html>
<?php
}
?>