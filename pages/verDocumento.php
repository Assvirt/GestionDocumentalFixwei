<?php 
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require 'conexion/bd.php';
//////////////////////PERMISOS////////////////////////

$formulario = 'divulgar'; //aqui se cambia el nombre del formulario

//require_once 'permisosPlataforma.php';

$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
     'id:grupo: '.$idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['listar'] == TRUE){
        $permisoListar = $permisos['listar'];    
    }
    
}

if($permisoListar == '1'){
    $visibleI = '';
}else{
    $visibleI = 'none';
}

//////////////////////PERMISOS////////////////////////

$acentos = $mysqli->query("SET NAMES 'utf8'");
$idDocumento = $_POST['idDocumento'];
$queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = '$idDocumento'")or die(mysqli_error($mysqli));
$datosDoc = $queryDoc->fetch_assoc();

$elaboraEliminacion = $datosDoc['elaboraElimanar'];
$revisaEliminacion = $datosDoc['revisaElimanar'];
$apruebaEliminacion = $datosDoc['apruebaElimanar'];

 '<br> - '.$elaboraActualizar = $datosDoc['elaboraActualizar'];
 ' - '.$revisaActualizar = $datosDoc['revisaActualizar'];
 ' - '.$apruebaActualizar = $datosDoc['apruebaActualizar'];

$verObsoletos = $_POST['verObsoletos'];


?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - DOCUMENTO</title>
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
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
  <style>
    .pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
  </style>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini" onload="nobackbutton();">
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
            <h1>Documento</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Documento</li>
            </ol>
          </div>
        </div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-10">
                    <div class="row">
                        
                        <?php 
                        
                            if(isset($verObsoletos)){
                                
                            
                        
                        ?>
                        
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="documentosObsoletos"><font color="white"><i class="fas fa-list"></i> Listado obsoletos</font></a></button>
                        </div>
                        
                        <?php 
                            }else{
                                ?>
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="listadoMaestro"><font color="white"><i class="fas fa-list"></i> Listado maestro</font></a></button>
                        </div>
                        
                        <?php
                            }
                        ?>
                        <div class="col-sm" style="display:<?php //echo $visibleI;?>;">
                                <span id="openDivulgacion" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Divulgación</font></span>
                        </div>
                        <div class="col-sm">
                             <span id="openFlujo" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Asignados del flujo</font></span>
                        </div>
            
                        <div class="col-sm">
                        </div>
                        <div class="col-sm">
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        <div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    
    
    <!-- tabla de divulgación-->
     <section class="content" id="divulgacion" style="display:none;">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/listadoMaestro/controlador" method="post" id="formularioBotton" onsubmit="return v(this)"  enctype="multipart/form-data"> <!-- controlador/listadoMaestro/controlador -->
                        <?php
                         if(isset($verObsoletos)){
                        ?>
                        <input name="obsoleto" value="1" type="hidden">
                        <?php
                         }
                        ?>
                        
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Divulgación</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                        
                          <div class="card-body">
                           
                        <div class="form-group ">
                        
                        <label>Seleccionar personal para divulgación: </label><br>
                            <input type="radio" id="rad_cargoAut" name="radiobtnAut" value="cargo" required>
                            <label for="cargo">Cargo</label> &nbsp;
                            <input type="radio" id="rad_usuarioAut" name="radiobtnAut" value="usuario" required>
                            <label for="usuarios">Usuarios</label> &nbsp;
                            <input type="radio" id="rad_grupoAut" name="radiobtnAut" value="grupo" required>
                            <label for="grupos">Grupos</label>
                            
                            <div class="select2-blue" id="listarCargos"  style="display:none;" >
                                
                                <label></label>
                                
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM cargos order by nombreCargos ASC");
                                ?>
                                <select class="duallistbox" id="selectA[]" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAutA[]"  >
                                    <?php
                                    while($extraerCargos=$consultaCargos->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerCargos['id_cargos']; ?>"><?php echo $extraerCargos['nombreCargos']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarUsuarios" style="display:none;">
                                
                                <label></label>
                               
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM usuario Order by nombres ASC");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAutB[]"  >
                                    <?php
                                    while($extraerCargos=$consultaCargos->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerCargos['id']; ?>"><?php echo $extraerCargos['nombres'].' '.$extraerCargos['apellidos']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarGrupos" style="display:none;">
                                
                                <label></label>
                               
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaGrupo=$mysqli->query("SELECT * FROM grupo Order by nombre ASC");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAutC[]"  >
                                    <?php
                                    while($extraerGrupo=$consultaGrupo->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerGrupo['id']; ?>"><?php echo $extraerGrupo['nombre']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <br><br>
                            <div class="select2-blue">
                                <textarea name="observaciones" class="form-control" placeholder="Observaciones"></textarea>
                            </div>
                        
                      </div> 
                      <?php
                            $idDocumento = $_POST['idDocumento'];
                            
                            $consultaDatosDocumento= $mysqli->query("SELECT * FROM documento WHERE id='$idDocumento'");
                            $extraerDatos = $consultaDatosDocumento->fetch_array(MYSQLI_ASSOC);
                            'Documento E: '. $DocumentoE = $extraerDatos['nombreOtro'];
                            'Documento P: '. $DocumentoP = $extraerDatos['nombrePDF'];
                        
                            if($DocumentoE !=NULL && $DocumentoP != NULL){
                                 $checkedA='Todo';
                                 
                            }
                            
                            if($DocumentoE !=NULL){
                                 $checkedB='Editable';
                                 
                            }
                            
                            
                            if($DocumentoP != NULL){
                                 $checkedC='PDF';
                                 
                            }
                      ?>
                      
                      
                            <label>Seleccionar Documento para divulgar: </label><br>
                            <?php
                             if($checkedA == 'Todo'){

                             ?>
                            <input type="radio" id="rad_editable" name="radiobtnDoc" value="editable"  required>
                            <label for="editable">Editable</label> &nbsp;
                            <input type="radio" id="rad_pdf" name="radiobtnDoc" value="pdf" required>
                            <label for="pdf">PDF</label> &nbsp;
                            <input type="radio" id="rad_ambos" name="radiobtnDoc" value="ambos" required>
                            <label for="ambos">Ambos</label>
                            <?php
                             }
                            ?>
                            <?php
                             if($checkedB == 'Editable' && $checkedC == NULL && $checkedA == NULL){

                             ?>
                            <input type="radio" id="rad_editable" name="radiobtnDoc" value="editable"  required>
                            <label for="editable">Editable</label> &nbsp;
                            
                            <?php
                             }
                            ?>
                            <?php
                             if($checkedC == 'PDF' && $checkedA == NULL && $checkedB == NULL){

                             ?>
                          
                            <input type="radio" id="rad_pdf" name="radiobtnDoc" value="pdf" required>
                            <label for="pdf">PDF</label> &nbsp;
                            
                            <?php
                             }
                            ?>
                        
                        
                            <div class="form-group ">
                                <div class="form-group" style="display:<?php echo $visibleSubir;?>">
                          
                                      <label for="upload-photo">Archivo (Máx 10MB):</label>
                                      <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="miInput" name="archivo"  >
                                            <label class="custom-file-label" >Subir Archivo</label>
                                        
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">Subir</span>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        
                        </div>
                        
                          <!-- /.card-body -->
                          <div class="card-footer"> <!--  class="btn btn-block btn-warning btn-sm no-print" -->
                              <button type="submit" name="notificar" id="notificar" class='btn btn-warning ' style="width:;"><font color="white"><i class="fas fa-bell"></i> Notificar</font></button>
                          </div>
                          
                          
                          <!-- /.card-footer-->
                        </div>
                        
                        <?php
                        // validamos si fue una creación, actualización ó eliminación
                        $validandoDocumento=$mysqli->query("SELECT * FROM documento WHERE id='".$_POST['idDocumento']."' ");
                        $extrerDocumento=$validandoDocumento->fetch_array(MYSQLI_ASSOC);
                        $validandoSolicitudDocumento=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='".$extrerDocumento['id_solicitud']."' ");
                        $extrerSolicitudDocumento=$validandoSolicitudDocumento->fetch_array(MYSQLI_ASSOC);
                        
                        if($extrerDocumento['tipoSolicitud'] == '1'){
                            $resultadoTipSolicitud='Creación';
                        }elseif($extrerDocumento['tipoSolicitud'] == '2'){
                            $resultadoTipSolicitud='Actualización';
                        }elseif($extrerDocumento['tipoSolicitud'] == '3'){
                            $resultadoTipSolicitud='Eliminación';
                        }
                        ?>
                        <input value="<?php echo $_POST['idDocumento'];?>" name="idDocumento" type="hidden">
                        <input value="<?php echo $resultadoTipSolicitud;?>" name="tipoSolicitudEnviar" type="hidden">
                        <input value="<?php echo $extrerDocumento['codificacion'].' - '.$extrerDocumento['version'];?>" name="codigo" type="hidden">
                        <input value="<?php echo $extrerDocumento['nombres'];?>" name="nombresDocumento" type="hidden">
                        <input value="<?php echo $extrerDocumento['nombreOtro'];?>" name="documentoEditable" type="hidden" placeholder="Editable...">
                        <input value="<?php echo $extrerDocumento['nombrePDF'];?>" name="documentoPDF" type="hidden" placeholder="Pdf...">
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    
    
    <!-- tabla de asignados-->
    <section class="content" id="asignadosFlujo" style="display:none;">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                   
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Asignados del flujo</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <?php
                            require_once 'conexion/bd.php';
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $data = $mysqli->query("SELECT permisos.listar, permisos.crear, permisos.editar, permisos.eliminar, permisos.formulario, formularios.* FROM formularios INNER JOIN permisos WHERE formularios.modulo = 'config' AND permisos.formulario =formularios.idFormulario AND permisos.idGrupo = '$idGrupo' ORDER BY formularios.orden");
                          ?>
                          <div class="card-body">
                            <div class="row post">
                                
                                <?php
                                //aca voy a validar si son usuarios o cargos los que se encargan de elaborar, revisar, aprobar            
                                
                                     $revisa = json_decode($datosDoc['revisa']);
                                    //$revisa = json_decode($datosDoc['revisaNombre']);
                                    $aprueba = json_decode($datosDoc['aprueba']);
                                    //$aprueba = json_decode($datosDoc['apruebaNombre']);
                                    $elabora = json_decode($datosDoc['elabora']);
                                    //$elabora = json_decode($datosDoc['elaboraNombre']);
                                ?>
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Elabora creación: </label><br>
                                            <?php 
                                            if($datosDoc['versionTemporal'] > 0){ /// en caso que venga por vigente o obsoleto
                                                $elabora=json_decode($datosDoc['elabora']);
                                                    if($elabora[0] == 'cargos' || $elabora[0] == 'usuarios'){
                                                    
                                                
                                                        if($elabora[0] == 'cargos'){
                                                            $longitud = count($elabora);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                                //saco el valor de cada elemento
                                                                //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                
                                                            	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                            }            
                                                        }
                                                        
                                                        if($elabora[0] == 'usuarios'){
                                                            $longitud = count($elabora);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                            $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$elabora[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                
                                                            } 
                                                        }
                                                    }else{
                                                        echo $datosDoc['elabora'];
                                                    }
                                            }else{
                                                if($elabora[0] == 'cargos' || $elabora[0] == 'usuarios'){
                                                    
                                                
                                                    if($elabora[0] == 'cargos'){
                                                        $longitud = count($elabora);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                        }            
                                                    }
                                                    
                                                    if($elabora[0] == 'usuarios'){ 
                                                        $longitud = count($elabora);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                            $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$elabora[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                           
                                                        	    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                           
                                                        } 
                                                    }
                                                }else{
                                                    
                                                    
                                                    $elabora=json_decode($datosDoc['elabora']);
                                                    if($elabora[0] == 'cargos' || $elabora[0] == 'usuarios'){
                                                    
                                                
                                                        if($elabora[0] == 'cargos'){
                                                            $longitud = count($elabora);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                                //saco el valor de cada elemento
                                                                //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                
                                                            	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                            }            
                                                        }
                                                        
                                                        if($elabora[0] == 'usuarios'){
                                                            $longitud = count($elabora);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                            $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$elabora[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                               
                                                            	    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                
                                                            } 
                                                        }
                                                    }else{
                                                        echo $datosDoc['elabora'];
                                                    }
                                                    
                                                    
                                                }
                                            }
                                           
                                            ?>
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Revisa creación: </label><br>
                                    <?php
                                    if($datosDoc['versionTemporal'] > 0){
                                        $revisa = json_decode($datosDoc['revisa']);
                                            if($revisa[0] == 'cargos' || $revisa[0] == 'usuarios'){
                                                if($revisa[0] == 'cargos'){
                                                    $longitud = count($revisa);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisa[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($revisa[0] == 'usuarios'){
                                                    $longitud = count($revisa);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$revisa[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                            echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                        
                                                
                                                    } 
                                                }
                                            }else{
                                               echo $datosDoc['revisa']; 
                                            }
                                    }else{
                                         if($revisa[0] == 'cargos' || $revisa[0] == 'usuarios'){
                                            if($revisa[0] == 'cargos'){
                                                $longitud = count($revisa);
                                                
                                                for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisa[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                }            
                                            }
                                            
                                            if($revisa[0] == 'usuarios'){
                                                $longitud = count($revisa);
                                                
                                                for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$revisa[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                    
                                                        echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    
                                                
                                                } 
                                            }
                                        }else{
                                            
                                            $revisa = json_decode($datosDoc['revisa']);
                                            if($revisa[0] == 'cargos' || $revisa[0] == 'usuarios'){
                                                if($revisa[0] == 'cargos'){
                                                    $longitud = count($revisa);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisa[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($revisa[0] == 'usuarios'){
                                                    $longitud = count($revisa);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$revisa[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                       
                                                            echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                        
                                                
                                                    } 
                                                }
                                            }else{
                                               echo $datosDoc['revisa']; 
                                            }
                                        }
                                    }
                                           
                                    ?>
                                </div>
                                
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Aprueba creación: </label><br>
                                    <?php
                                    if($datosDoc['versionTemporal'] > 0){
                                         $aprueba = json_decode($datosDoc['aprueba']);
                                            if($aprueba[0] == 'cargos' || $aprueba[0] == 'usuarios'){
                                                if($aprueba[0] == 'cargos'){
                                                    $longitud = count($aprueba);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$aprueba[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($aprueba[0] == 'usuarios'){
                                                    $longitud = count($aprueba);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$aprueba[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                            echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                        
                                                    } 
                                                }
                                            }else{
                                                echo $datosDoc['aprueba'];
                                            }
                                    }else{  
                                        if($aprueba[0] == 'cargos' || $aprueba[0] == 'usuarios'){  
                                            if($aprueba[0] == 'cargos'){
                                                $longitud = count($aprueba);
                                                
                                                for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$aprueba[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                }            
                                            }
                                            
                                            if($aprueba[0] == 'usuarios'){ 
                                                $longitud = count($aprueba);
                                                
                                                for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$aprueba[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                    
                                                        echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    
                                                } 
                                            }
                                        }else{
                                            ////// aplicamos esta validación en la creación, actualización, eliminación y en el responsable de disposición
                                            $aprueba = json_decode($datosDoc['aprueba']);
                                            if($aprueba[0] == 'cargos' || $aprueba[0] == 'usuarios'){
                                                if($aprueba[0] == 'cargos'){
                                                    $longitud = count($aprueba);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$aprueba[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($aprueba[0] == 'usuarios'){
                                                    $longitud = count($aprueba);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$aprueba[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                        
                                                            echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                        
                                                    } 
                                                }
                                            }else{
                                                echo $datosDoc['aprueba'];
                                            }
                                        }
                                    }
                                          
                                    ?>
                                </div>
                                
                                <!-- ------ -->
                                
                                
                                
                                
                                <?php
                                $idDocumento.'<br>';
                                $consultaGeneralDocumentoValidnado=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento' ");
                                $extraerDocumentoSolicitadoValidnado=$consultaGeneralDocumentoValidnado->fetch_array(MYSQLI_ASSOC);
                                $idProceso=$extraerDocumentoSolicitadoValidnado['proceso'];
                                $idTipoDocumento=$extraerDocumentoSolicitadoValidnado['tipo_documento'];
                                $versionamiento=$extraerDocumentoSolicitadoValidnado['version'];
                                $nombreDocumentaValidarActu=$extraerDocumentoSolicitadoValidnado['codificacion'];
                               '<br><br>';
                                
                                $consultaGeneralDocumentoValidnadoExistencia=$mysqli->query("SELECT * FROM documento WHERE proceso='$idProceso' AND tipo_documento='$idTipoDocumento' AND codificacion='$nombreDocumentaValidarActu' ");
                                $conteoRegistro='0';
                                $conteoRegistroO='0';
                                 $conteoRegistroB='0';
                                while($extraerDocumentoSolicitadoValidnadoExistencia=$consultaGeneralDocumentoValidnadoExistencia->fetch_array()){
                                    
                                    if($extraerDocumentoSolicitadoValidnadoExistencia['elaboraActualizar'] != NULL){
                                        
                                    }else{
                                        continue;
                                    }
                                    
                                    if($extraerDocumentoSolicitadoValidnadoExistencia['id'] > $idDocumento){
                                        continue;
                                    }else{
                                        
                                    }
                                        
                                    $conteoRegistroB++;
                                    if($versionamiento == 1){
                                        
                                    }else{
                                         'Conteo: '.$conteoRegistroO++; 
                                         ' - '.$versionamiento-1;
                                         '<br>';
                                        //if($conteoRegistro++ < $versionamiento-1){
                                        $idPrimario=$extraerDocumentoSolicitadoValidnadoExistencia['id']; 
                                        
                                         'documento: '.$idDocumento; 
                                         '('.$idPrimario.')';
                                         ' - '.$idDocumento;
                                         '<br>';
                                            
                                            ?>
                                                <?php if($elaboraActualizar != NULL){$verElaboraA="";}else{$verElaboraA="none";}?>
                                                <div class="form-group col-sm-4" style="display:<?php echo $verElaboraA;?>">
                                                    <label class="text-dark">Elabora actualización: </label><br>
                                                            <?php
                                                                $elabora = json_decode($extraerDocumentoSolicitadoValidnadoExistencia['elaboraActualizar']);
                                                                
                                                                if($elabora[0] == 'cargos'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                    	
                                                                    
                                                                    }            
                                                                }
                                                                
                                                                if($elabora[0] == 'usuarios'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos, id FROM usuario WHERE id = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                        
                                                                            echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                       
                                                                    	 '<br>id documento: '.$extraerDocumentoSolicitadoValidnadoExistencia['id'];
                                                                    } 
                                                                }
                                                            
                                                            ?>
                                                </div>
                                                <!-- ------ -->
                                                
                                                
                                                <!-- ------ -->
                                                <?php if($revisaActualizar != NULL){$verRevisaA="";}else{$verRevisaA="none";}?>
                                                <div class="form-group col-sm-4" style="display:<?php echo $verRevisaA;?>">
                                                    <label class="text-dark">Revisa actualización: </label><br>
                                                            <?php
                                                                $elabora = json_decode($extraerDocumentoSolicitadoValidnadoExistencia['revisaActualizar']);
                                                                
                                                                if($elabora[0] == 'cargos'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                    	
                                                                    }            
                                                                }
                                                                
                                                                if($elabora[0] == 'usuarios'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                       
                                                                    	    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                        
                                                                    } 
                                                                }
                                                            
                                                            ?>
                                                </div>
                                                <!-- ------ -->
                                                
                                                <!-- ------ -->
                                                <?php if($apruebaActualizar != NULL){$verApruebaA="";}else{$verApruebaA="none";}?>
                                                <div class="form-group col-sm-4" style="display:<?php echo $verApruebaA;?>">
                                                    <label class="text-dark">Aprueba actualización: </label><br>
                                                            <?php
                                                                $elabora = json_decode($extraerDocumentoSolicitadoValidnadoExistencia['apruebaActualizar']);
                                                                
                                                                if($elabora[0] == 'cargos'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                    
                                                                    }            
                                                                }
                                                                
                                                                if($elabora[0] == 'usuarios'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos, id FROM usuario WHERE id = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                       
                                                                    	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                        
                                                                    } 
                                                                }
                                                            
                                                            ?>
                                                </div>
                                                <!-- ------ -->
                                                
                                            <?php  
                                            /*} */
                                        //}else{
                                         
                                        //}
                                    }
                                    //echo '<br>';
                                    
                                }
                                
                                
                               
                                
                                //// si el estado no está aprobado, no debería mostrar la trazabilidad de la eliminación
                                if($datosDoc['estadoElimina'] == 'Aprobado'){
                                ?>
                                <!-- ------ -->
                                <?php if($elaboraEliminacion != NULL){$verElaboraE="";}else{$verElaboraE="none";}?>
                                <div class="form-group col-sm-4" style="display:<?php echo $verElaboraE;?>">
                                    <label class="text-dark">Elabora eliminación: </label><br>
                                            <?php
                                                $elabora = json_decode($datosDoc['elaboraElimanar']);
                                                
                                                if($elabora[0] == 'cargos'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($elabora[0] == 'usuarios'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    } 
                                                }
                                            
                                            ?>
                                </div>
                                <!-- ------ -->
                                
                                <!-- ------ -->
                                <?php if($revisaEliminacion != NULL){$verRevisaE="";}else{$verRevisaE="none";}?>
                                <div class="form-group col-sm-4" style="display:<?php echo $verRevisaE;?>">
                                    <label class="text-dark">Revisa eliminación: </label><br>
                                            <?php
                                                $elabora = json_decode($datosDoc['revisaElimanar']);
                                                
                                                if($elabora[0] == 'cargos'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($elabora[0] == 'usuarios'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    } 
                                                }
                                            
                                            ?>
                                </div>
                                <!-- ------ -->
                                
                                
                                <!-- ------ -->
                                <?php if($apruebaEliminacion != NULL){$verApruebaE="";}else{$verApruebaE="none";}?>
                                <div class="form-group col-sm-4" style="display:<?php echo $verApruebaE;?>">
                                    <label class="text-dark">Aprueba eliminación: </label><br>
                                            <?php
                                                $elabora = json_decode($datosDoc['apruebaElimanar']);
                                                
                                                if($elabora[0] == 'cargos'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($elabora[0] == 'usuarios'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    } 
                                                }
                                            
                                            ?>
                                </div>
                                <!-- ------ -->
                                <?php
                                }
                                ?>
                                
                                <div class="form-group col-sm-6">
                                
                                </div>
                                
                                <div class="form-group col-sm-6">
                                
                                </div>
                            
                            </div>    
                                
                                
                            
                            
                           
                            
                           
                               
                               
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Información del documento</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <?php
                            require_once 'conexion/bd.php';
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $data = $mysqli->query("SELECT permisos.listar, permisos.crear, permisos.editar, permisos.eliminar, permisos.formulario, formularios.* FROM formularios INNER JOIN permisos WHERE formularios.modulo = 'config' AND permisos.formulario =formularios.idFormulario AND permisos.idGrupo = '$idGrupo' ORDER BY formularios.orden");
                          ?>
                          <div class="card-body">
                            <!--INICIO ROW-->
                            <div class="row post">
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Nombre del documento: </label><br>
                                    <span><?php echo $datosDoc['nombres']?></span>
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Tipo documento:</label><br>
                                        <?php
                                            require_once'conexion/bd.php';
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            
                                            if($datosDoc['tipo_documento'] != NULL){
                                                $resultado=$mysqli->query("SELECT * FROM tipoDocumento ORDER BY nombre");
                                                while ($columna = mysqli_fetch_array( $resultado )) {
                                                    if($datosDoc['tipo_documento'] == $columna['id']){
                                                        echo $columna['nombre'];
                                                    }
                                                }   
                                            }else{
                                                echo $datosDoc['nombreTipoD'];
                                            }
                                            
                                        ?>
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Proceso:</label><br>
                                    <?php
                                        echo $datosDoc['nombreProceso'];
                                    /*
                                        require_once'conexion/bd.php';
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $resultado=$mysqli->query("SELECT * FROM procesos ORDER BY nombre");
                                    ?>
                                    <?php
                                        while ($columna = mysqli_fetch_array( $resultado )) { 
                                            if($datosDoc['proceso'] == $columna['id']){
                                                
                                                echo $columna['nombre'];
                                            }
                                        }*/
                                        ?>
                                    
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Método de creación: </label><br>
                                    
                                    <?php
                                        
                                        if($datosDoc['metodo'] == "html"){
                                            echo "HTML";
                                        }else{
                                            echo "Documento PDF";
                                        }
                                        
                                    ?>
                                </div>
                                
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Ubicación: </label><br>
                                    <?php 
                                    if(isset($verObsoletos)){
                                        echo 'Fixwei/Obsoletos';
                                    }else{
                                        echo $datosDoc['ubicacion'];
                                    }
                                    ?>
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Código: </label><br>
                                    <?php echo $datosDoc['codificacion']; ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Versión: </label><br>
                                    <?php echo $datosDoc['version']; ?>
                                </div>
                                <div class="form-group col-sm-4">
                                    <?php
                                        require_once'conexion/bd.php';
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $resultado=$mysqli->query("SELECT * FROM normatividad");
                                        //$arrayNormas = json_decode($datosDoc['norma']);
                                        $arrayNormas = ($datosDoc['normaNombre']);
                                    ?>
                                    <label class="text-dark">Normas: </label><br>
                                      
                                        <?php
                                        
                                            if(!$arrayNormas){
                                                echo "Sin normas";    
                                            }else{
                                               $retiramosPrmerParametro=str_replace('["',"-",$arrayNormas);
                                               $retiramosSegundoParametro=str_replace('","',"<br>-",$retiramosPrmerParametro);
                                               echo $retiramosTercerParametro=str_replace('"]',"",$retiramosSegundoParametro);
                                                //echo str_replace("world","Peter","Hello world!"); // resultado: Hello Peter
                                                
                                                /*while ($columna = mysqli_fetch_array( $resultado )) { 
                                                    if(in_array($columna['id'],$arrayNormas)){
                                                     
                                                    $seleccionarNorm = "selected";
                                                    
                                                    echo"<strong>- </strong>".$columna['nombre']; echo "<br>";
                                                      
                                                        
                                                    }
                                                }*/
                                            }
                                        
                                           
                                            
                                        ?>
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <?php
                                    require_once'conexion/bd.php';
                                    $resultado=$mysqli->query("SELECT id, nombre FROM documentoExterno");
                                    //$arrayDocE = json_decode($datosDoc['documento_externo']);
                                    $arrayDocE = ($datosDoc['externoNombre']);
                                    ?>
                                    <label class="text-dark">Documentos externos: </label><br>
                                        <?php
                                        if(!$arrayDocE){
                                            echo "Sin documentos externos.";
                                        }else{
                                            $retiramosPrmerParametro=str_replace('["',"-",$arrayDocE);
                                            $retiramosSegundoParametro=str_replace('","',"<br>-",$retiramosPrmerParametro);
                                            echo $retiramosTercerParametro=str_replace('"]',"",$retiramosSegundoParametro);
                                            /*while ($columna = mysqli_fetch_array( $resultado )) {
                                                if(in_array($columna['id'],$arrayDocE)){
                                                    echo"<strong>- </strong> ".$columna['nombre']; echo "<br>";        
                                                }
                                            }*/
                                        }
                                             
                                        ?>
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <?php
                                    require_once'conexion/bd.php';
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultado=$mysqli->query("SELECT id, nombre FROM definicion");
                                    //$arrayDefiniciones = json_decode($datosDoc['definiciones']);
                                    $arrayDefiniciones = ($datosDoc['definicionNombre']);
                                    ?>
                                    <label class="text-dark">Definiciones: </label><br>
                                        <?php
                                            
                                            if(!$arrayDefiniciones){
                                                echo "Sin definiciones.";
                                            }else{
                                                $retiramosPrmerParametro=str_replace('["',"-",$arrayDefiniciones);
                                                $retiramosSegundoParametro=str_replace('","',"<br>-",$retiramosPrmerParametro);
                                                echo $retiramosTercerParametro=str_replace('"]',"",$retiramosSegundoParametro);
                                                /*while ($columna = mysqli_fetch_array( $resultado )) { 
                                                    if(in_array($columna['id'],$arrayDefiniciones)){
                                                        echo"<strong>- </strong> ".$columna['nombre']; echo "<br>";         
                                                    }
                                                }*/
                                            }
                                        
                                            
                                        ?> 
                                </div>
                                
                                
                               
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Meses para la próxima revisión:</label><br> <?php echo $datosDoc['mesesRevision'];?>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                
                                </div>
                            
                            </div>
                            <!--FIN ROW-->
                            
                            
                            <div class="row post">
                                
                                <?php
                                //aca voy a validar si son usuarios o cargos los que se encargan de elaborar, revisar, aprobar            
                                
                                     $revisa = json_decode($datosDoc['revisa']);
                                    //$revisa = json_decode($datosDoc['revisaNombre']);
                                    $aprueba = json_decode($datosDoc['aprueba']);
                                    //$aprueba = json_decode($datosDoc['apruebaNombre']);
                                    $elabora = json_decode($datosDoc['elabora']);
                                    //$elabora = json_decode($datosDoc['elaboraNombre']);
                                ?>
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Elabora creación: </label><br>
                                            <?php 
                                            /*if($datosDoc['versionTemporal'] > 0){ /// en caso que venga por vigente o obsoleto
                                                $elabora=json_decode($datosDoc['elabora']);
                                                    if($elabora[0] == 'cargos' || $elabora[0] == 'usuarios'){
                                                    
                                                
                                                        if($elabora[0] == 'cargos'){
                                                            $longitud = count($elabora);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                                //saco el valor de cada elemento
                                                                //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                
                                                            	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                            }            
                                                        }
                                                        
                                                        if($elabora[0] == 'usuarios'){
                                                            $longitud = count($elabora);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                            $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$elabora[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                
                                                            } 
                                                        }
                                                    }else{
                                                        echo $datosDoc['elabora'];
                                                    }
                                            }else{
                                                if($elabora[0] == 'cargos' || $elabora[0] == 'usuarios'){
                                                    
                                                
                                                    if($elabora[0] == 'cargos'){
                                                        $longitud = count($elabora);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                        }            
                                                    }
                                                    
                                                    if($elabora[0] == 'usuarios'){ 
                                                        $longitud = count($elabora);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                            $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$elabora[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            if($datosDoc['elaborado'] == $nombres['id']){
                                                        	    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                            }else{
                                                        
                                                                $accionCreacion = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                                $extraerAccionCreacion = $accionCreacion->fetch_array(MYSQLI_ASSOC);
                                                                if($extraerAccionCreacion['versionTemporal'] > 0){ 
                                                                    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                }
                                                            }
                                                        } 
                                                    }
                                                }else{
                                                    
                                                    
                                                    $elabora=json_decode($datosDoc['elabora']);
                                                    if($elabora[0] == 'cargos' || $elabora[0] == 'usuarios'){
                                                    
                                                
                                                        if($elabora[0] == 'cargos'){
                                                            $longitud = count($elabora);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                                //saco el valor de cada elemento
                                                                //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                
                                                            	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                            }            
                                                        }
                                                        
                                                        if($elabora[0] == 'usuarios'){
                                                            $longitud = count($elabora);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                            $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$elabora[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                if($datosDoc['elaborado'] == $nombres['id']){
                                                            	    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                }
                                                            } 
                                                        }
                                                    }else{
                                                        echo $datosDoc['elabora'];
                                                    }
                                                    
                                                    
                                                }
                                            }*/ 
                                            if($datosDoc['versionTemporal'] > 0){
                                                //echo 'Viene por vigente primera pregunta<br>';
                                                
                                                    $elabora=json_decode($datosDoc['elabora']);
                                                    if($elabora[0] == 'cargos' || $elabora[0] == 'usuarios'){
                                                    
                                                
                                                        if($elabora[0] == 'cargos'){
                                                            $longitud = count($elabora);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                                //saco el valor de cada elemento
                                                                //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                
                                                            	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                            }            
                                                        }
                                                        
                                                        if($elabora[0] == 'usuarios'){
                                                            $longitud = count($elabora);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                            $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$elabora[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                
                                                            } 
                                                        }
                                                    }else{
                                                        echo $datosDoc['elabora'];
                                                    }
                                                
                                            }else{ 
                                                if($datosDoc['idCreacion'] != NULL){ 
                                                    //echo 'Viene por actualización<br>';
                                                    
                                                    
                                                    // preguntamos si venia por vigente o obsoleto masivo
                                                    $accionCreacion_pregunta_vigente = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                    $extraerAccionCreacion_pregunta_vigente = $accionCreacion_pregunta_vigente->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($extraerAccionCreacion_pregunta_vigente['versionTemporal'] > 0){ 
                                                        //echo 'viene por vigente segunda pregunta';
                                                        $accionCreacion = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                        $extraerAccionCreacion = $accionCreacion->fetch_array(MYSQLI_ASSOC);
                                                        $elabora=json_decode($extraerAccionCreacion['elabora']);
                                                        if($elabora[0] == 'cargos' || $elabora[0] == 'usuarios'){
                                                        
                                                    
                                                            if($elabora[0] == 'cargos'){
                                                                $longitud = count($elabora);
                                                                
                                                                for($i=1; $i<$longitud; $i++){
                                                                    //saco el valor de cada elemento
                                                                    //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                    
                                                                	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                }            
                                                            }
                                                            
                                                            if($elabora[0] == 'usuarios'){
                                                                $longitud = count($elabora);
                                                                
                                                                for($i=1; $i<$longitud; $i++){
                                                                //saco el valor de cada elemento
                                                                //echo '<strong>- </strong> '.$elabora[$i].'<br>';
                                                                $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$elabora[$i]'");
                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                    
                                                                } 
                                                            }
                                                        }else{
                                                            echo $extraerAccionCreacion['elabora'];
                                                        }
                                                    }else{
                                                        $accionCreacion = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                        $extraerAccionCreacion = $accionCreacion->fetch_array(MYSQLI_ASSOC);
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '".$extraerAccionCreacion['elaborado']."'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    }
                                                }else{
                                                    //echo 'Creación<br>';
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '".$datosDoc['elaborado']."'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                }
                                            }
                                            ?>
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Revisa creación: </label><br>
                                    <?php
                                    /*if($datosDoc['versionTemporal'] > 0){
                                        $revisa = json_decode($datosDoc['revisa']);
                                            if($revisa[0] == 'cargos' || $revisa[0] == 'usuarios'){
                                                if($revisa[0] == 'cargos'){
                                                    $longitud = count($revisa);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisa[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($revisa[0] == 'usuarios'){
                                                    $longitud = count($revisa);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$revisa[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                            echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                        
                                                
                                                    } 
                                                }
                                            }else{
                                               echo $datosDoc['revisa']; 
                                            }
                                    }else{
                                         if($revisa[0] == 'cargos' || $revisa[0] == 'usuarios'){
                                            if($revisa[0] == 'cargos'){
                                                $longitud = count($revisa);
                                                
                                                for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisa[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                }            
                                            }
                                            
                                            if($revisa[0] == 'usuarios'){
                                                $longitud = count($revisa);
                                                
                                                for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$revisa[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                    if($datosDoc['revisadoo'] == $nombres['id']){
                                                        echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    }else{
                                                        
                                                            $accionCreacion = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                            $extraerAccionCreacion = $accionCreacion->fetch_array(MYSQLI_ASSOC);
                                                            if($extraerAccionCreacion['versionTemporal'] > 0){ 
                                                                echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                            }
                                                    }
                                                
                                                } 
                                            }
                                        }else{
                                            
                                            $revisa = json_decode($datosDoc['revisa']);
                                            if($revisa[0] == 'cargos' || $revisa[0] == 'usuarios'){
                                                if($revisa[0] == 'cargos'){
                                                    $longitud = count($revisa);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisa[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($revisa[0] == 'usuarios'){
                                                    $longitud = count($revisa);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$revisa[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                        if($datosDoc['revisadoo'] == $nombres['id']){
                                                            echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                        }
                                                
                                                    } 
                                                }
                                            }else{
                                               echo $datosDoc['revisa']; 
                                            }
                                        }
                                    }*/
                                            if($datosDoc['versionTemporal'] > 0){
                                                //echo 'Viene por vigente<br>';
                                                $revisa = json_decode($datosDoc['revisa']);
                                                if($revisa[0] == 'cargos' || $revisa[0] == 'usuarios'){
                                                    if($revisa[0] == 'cargos'){
                                                        $longitud = count($revisa);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisa[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                        }            
                                                    }
                                                    
                                                    if($revisa[0] == 'usuarios'){
                                                        $longitud = count($revisa);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$revisa[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                                echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                            
                                                    
                                                        } 
                                                    }
                                                }else{
                                                   echo $datosDoc['revisa']; 
                                                }
                                                   
                                            }else{
                                                if($datosDoc['idCreacion'] != NULL){
                                                    //echo 'Viene por actualización<br>';
                                                    
                                                    // preguntamos si venia por vigente o obsoleto masivo
                                                    $accionCreacion_pregunta_vigente = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                    $extraerAccionCreacion_pregunta_vigente = $accionCreacion_pregunta_vigente->fetch_array(MYSQLI_ASSOC);
                                                    if($extraerAccionCreacion_pregunta_vigente['versionTemporal'] > 0){ 
                                                        //echo 'viene por vigente segunda pregunta';
                                                        $accionCreacion = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                        $extraerAccionCreacion = $accionCreacion->fetch_array(MYSQLI_ASSOC);
                                                        $revisa = json_decode($extraerAccionCreacion['revisa']);
                                                        if($revisa[0] == 'cargos' || $revisa[0] == 'usuarios'){
                                                            if($revisa[0] == 'cargos'){
                                                                $longitud = count($revisa);
                                                                
                                                                for($i=1; $i<$longitud; $i++){
                                                                    //saco el valor de cada elemento
                                                                    //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisa[$i]'");
                                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                    
                                                                	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                }            
                                                            }
                                                            
                                                            if($revisa[0] == 'usuarios'){
                                                                $longitud = count($revisa);
                                                                
                                                                for($i=1; $i<$longitud; $i++){
                                                                //saco el valor de cada elemento
                                                                //echo "<strong>- </strong> ".$revisa[$i]."<br>";
                                                                $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$revisa[$i]'");
                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                
                                                                        echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                    
                                                            
                                                                } 
                                                            }
                                                        }else{
                                                           echo $extraerAccionCreacion['revisa']; 
                                                        }
                                                    }else{
                                                    
                                                    $accionCreacion = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                    $extraerAccionCreacion = $accionCreacion->fetch_array(MYSQLI_ASSOC);
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '".$extraerAccionCreacion['revisadoo']."'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    }
                                                }else{
                                                    //echo 'Creación<br>';
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '".$datosDoc['revisadoo']."'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                }
                                            }
                                    ?>
                                </div>
                                
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Aprueba creación: </label><br>
                                    <?php
                                    /*if($datosDoc['versionTemporal'] > 0){
                                         $aprueba = json_decode($datosDoc['aprueba']);
                                            if($aprueba[0] == 'cargos' || $aprueba[0] == 'usuarios'){
                                                if($aprueba[0] == 'cargos'){
                                                    $longitud = count($aprueba);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$aprueba[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($aprueba[0] == 'usuarios'){
                                                    $longitud = count($aprueba);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$aprueba[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                            echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                        
                                                    } 
                                                }
                                            }else{
                                                echo $datosDoc['aprueba'];
                                            }
                                    }else{  
                                        if($aprueba[0] == 'cargos' || $aprueba[0] == 'usuarios'){  
                                            if($aprueba[0] == 'cargos'){
                                                $longitud = count($aprueba);
                                                
                                                for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$aprueba[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                }            
                                            }
                                            
                                            if($aprueba[0] == 'usuarios'){ 
                                                $longitud = count($aprueba);
                                                
                                                for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$aprueba[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                    if($datosDoc['aprobado'] == $nombres['id']){
                                                        echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    }else{
                                                        
                                                            $accionCreacion = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                            $extraerAccionCreacion = $accionCreacion->fetch_array(MYSQLI_ASSOC);
                                                            if($extraerAccionCreacion['versionTemporal'] > 0){ 
                                                                echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                            }
                                                    }
                                                } 
                                            }
                                        }else{
                                            ////// aplicamos esta validación en la creación, actualización, eliminación y en el responsable de disposición
                                            $aprueba = json_decode($datosDoc['aprueba']);
                                            if($aprueba[0] == 'cargos' || $aprueba[0] == 'usuarios'){
                                                if($aprueba[0] == 'cargos'){
                                                    $longitud = count($aprueba);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$aprueba[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($aprueba[0] == 'usuarios'){
                                                    $longitud = count($aprueba);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$aprueba[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                        if($datosDoc['aprobado'] == $nombres['id']){
                                                            echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                        }
                                                    } 
                                                }
                                            }else{
                                                echo $datosDoc['aprueba'];
                                            }
                                        }
                                    }*/
                                            if($datosDoc['versionTemporal'] > 0){
                                                //echo 'Viene por vigente<br>';
                                                $aprueba = json_decode($datosDoc['aprueba']);
                                                if($aprueba[0] == 'cargos' || $aprueba[0] == 'usuarios'){
                                                    if($aprueba[0] == 'cargos'){
                                                        $longitud = count($aprueba);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$aprueba[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                        }            
                                                    }
                                                    
                                                    if($aprueba[0] == 'usuarios'){
                                                        $longitud = count($aprueba);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$aprueba[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                                echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                            
                                                        } 
                                                    }
                                                }else{
                                                    echo $datosDoc['aprueba'];
                                                }
                                                   
                                            }else{
                                                if($datosDoc['idCreacion'] != NULL){
                                                    //echo 'Viene por actualización<br>';
                                                    // preguntamos si venia por vigente o obsoleto masivo
                                                    $accionCreacion_pregunta_vigente = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                    $extraerAccionCreacion_pregunta_vigente = $accionCreacion_pregunta_vigente->fetch_array(MYSQLI_ASSOC);
                                                    if($extraerAccionCreacion_pregunta_vigente['versionTemporal'] > 0){ 
                                                        //echo 'viene por vigente segunda pregunta';
                                                        $accionCreacion = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                        $extraerAccionCreacion = $accionCreacion->fetch_array(MYSQLI_ASSOC);
                                                    
                                                        $aprueba = json_decode($extraerAccionCreacion['aprueba']);
                                                        if($aprueba[0] == 'cargos' || $aprueba[0] == 'usuarios'){
                                                            if($aprueba[0] == 'cargos'){
                                                                $longitud = count($aprueba);
                                                                
                                                                for($i=1; $i<$longitud; $i++){
                                                                    //saco el valor de cada elemento
                                                                    //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$aprueba[$i]'");
                                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                    
                                                                	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                }            
                                                            }
                                                            
                                                            if($aprueba[0] == 'usuarios'){
                                                                $longitud = count($aprueba);
                                                                
                                                                for($i=1; $i<$longitud; $i++){
                                                                //saco el valor de cada elemento
                                                                //echo "<strong>- </strong> ".$aprueba[$i]."<br>";
                                                                $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$aprueba[$i]'");
                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                
                                                                        echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                    
                                                                } 
                                                            }
                                                        }else{
                                                            echo $datosDoc['aprueba'];
                                                        }
                                                    }else{
                                                    $accionCreacion = $mysqli->query("SELECT * FROM documento WHERE id = '".$datosDoc['idCreacion']."' ");
                                                    $extraerAccionCreacion = $accionCreacion->fetch_array(MYSQLI_ASSOC);
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '".$extraerAccionCreacion['aprobado']."'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    }
                                                }else{
                                                    //echo 'Creación<br>';
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '".$datosDoc['aprobado']."'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                }
                                            }
                                    ?>
                                </div>
                                
                                <!-- ------ -->
                                
                                
                                
                                
                                <?php
                                $idDocumento.'<br>';
                                $consultaGeneralDocumentoValidnado=$mysqli->query("SELECT * FROM documento WHERE id='$idDocumento' ");
                                $extraerDocumentoSolicitadoValidnado=$consultaGeneralDocumentoValidnado->fetch_array(MYSQLI_ASSOC);
                                $idProceso=$extraerDocumentoSolicitadoValidnado['proceso'];
                                $idTipoDocumento=$extraerDocumentoSolicitadoValidnado['tipo_documento'];
                                $versionamiento=$extraerDocumentoSolicitadoValidnado['version'];
                                $nombreDocumentaValidarActu=$extraerDocumentoSolicitadoValidnado['codificacion'];
                               '<br><br>';
                                
                                $consultaGeneralDocumentoValidnadoExistencia=$mysqli->query("SELECT * FROM documento WHERE proceso='$idProceso' AND tipo_documento='$idTipoDocumento' AND codificacion='$nombreDocumentaValidarActu' ");
                                $conteoRegistro='0';
                                $conteoRegistroO='0';
                                 $conteoRegistroB='0';
                                while($extraerDocumentoSolicitadoValidnadoExistencia=$consultaGeneralDocumentoValidnadoExistencia->fetch_array()){
                                    
                                    if($extraerDocumentoSolicitadoValidnadoExistencia['elaboraActualizar'] != NULL){
                                        
                                    }else{
                                        continue;
                                    }
                                    
                                    if($extraerDocumentoSolicitadoValidnadoExistencia['id'] > $idDocumento){
                                        continue;
                                    }else{
                                        
                                    }
                                        
                                    $conteoRegistroB++;
                                    if($versionamiento == 1){
                                        
                                    }else{
                                         'Conteo: '.$conteoRegistroO++; 
                                         ' - '.$versionamiento-1;
                                         '<br>';
                                        //if($conteoRegistro++ < $versionamiento-1){
                                        $idPrimario=$extraerDocumentoSolicitadoValidnadoExistencia['id']; 
                                        
                                         'documento: '.$idDocumento; 
                                         '('.$idPrimario.')';
                                         ' - '.$idDocumento;
                                         '<br>';
                                            
                                            ?>
                                                <?php if($elaboraActualizar != NULL){$verElaboraA="";}else{$verElaboraA="none";}?>
                                                <div class="form-group col-sm-4" style="display:<?php echo $verElaboraA;?>">
                                                    <label class="text-dark">Elabora actualización: </label><br>
                                                            <?php
                                                                $elabora = json_decode($extraerDocumentoSolicitadoValidnadoExistencia['elaboraActualizar']);
                                                                
                                                                if($elabora[0] == 'cargos'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                    	//echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                    	
                                                                    	$queryNombresCargo = $mysqli->query("SELECT cargo,id FROM usuario WHERE id = '".$extraerDocumentoSolicitadoValidnadoExistencia['elaborado']."'");
                                                                        $nombresCargo = $queryNombresCargo->fetch_array(MYSQLI_ASSOC); 
                                                                    	
                                                                    	
                                                                    	if($elabora[$i] == $nombresCargo['cargo']){ 
                                                                            echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                        }
                                                                    }            
                                                                }
                                                                
                                                                if($elabora[0] == 'usuarios'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos, id FROM usuario WHERE id = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                        if($extraerDocumentoSolicitadoValidnadoExistencia['elaborado'] == $nombres['id']){ 
                                                                            echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                        }
                                                                    	 '<br>id documento: '.$extraerDocumentoSolicitadoValidnadoExistencia['id'];
                                                                    } 
                                                                }
                                                            
                                                            ?>
                                                </div>
                                                <!-- ------ -->
                                                
                                                
                                                <!-- ------ -->
                                                <?php if($revisaActualizar != NULL){$verRevisaA="";}else{$verRevisaA="none";}?>
                                                <div class="form-group col-sm-4" style="display:<?php echo $verRevisaA;?>">
                                                    <label class="text-dark">Revisa actualización: </label><br>
                                                            <?php
                                                                $elabora = json_decode($extraerDocumentoSolicitadoValidnadoExistencia['revisaActualizar']);
                                                                
                                                                if($elabora[0] == 'cargos'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                    	//echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                    	$queryNombresCargo = $mysqli->query("SELECT cargo,id FROM usuario WHERE id = '".$extraerDocumentoSolicitadoValidnadoExistencia['revisadoo']."'");
                                                                        $nombresCargo = $queryNombresCargo->fetch_array(MYSQLI_ASSOC); 
                                                                    	
                                                                    	
                                                                    	if($elabora[$i] == $nombresCargo['cargo']){ 
                                                                            echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                        }
                                                                    }            
                                                                }
                                                                
                                                                if($elabora[0] == 'usuarios'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        if($extraerDocumentoSolicitadoValidnadoExistencia['revisadoo'] == $nombres['id']){
                                                                    	    echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                        }
                                                                    } 
                                                                }
                                                            
                                                            ?>
                                                </div>
                                                <!-- ------ -->
                                                
                                                <!-- ------ -->
                                                <?php if($apruebaActualizar != NULL){$verApruebaA="";}else{$verApruebaA="none";}?>
                                                <div class="form-group col-sm-4" style="display:<?php echo $verApruebaA;?>">
                                                    <label class="text-dark">Aprueba actualización: </label><br>
                                                            <?php
                                                                $elabora = json_decode($extraerDocumentoSolicitadoValidnadoExistencia['apruebaActualizar']);
                                                                
                                                                if($elabora[0] == 'cargos'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        
                                                                    	//echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                    	$queryNombresCargo = $mysqli->query("SELECT cargo,id FROM usuario WHERE id = '".$extraerDocumentoSolicitadoValidnadoExistencia['aprobado']."'");
                                                                        $nombresCargo = $queryNombresCargo->fetch_array(MYSQLI_ASSOC); 
                                                                    	
                                                                    	
                                                                    	if($elabora[$i] == $nombresCargo['cargo']){ 
                                                                            echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                                        }
                                                                    }            
                                                                }
                                                                
                                                                if($elabora[0] == 'usuarios'){
                                                                    $longitud = count($elabora);
                                                                    
                                                                    for($i=1; $i<$longitud; $i++){
                                                                        //saco el valor de cada elemento
                                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos, id FROM usuario WHERE id = '$elabora[$i]'");
                                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                        if($extraerDocumentoSolicitadoValidnadoExistencia['aprobado'] == $nombres['id']){
                                                                    	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                                        }
                                                                    } 
                                                                }
                                                            
                                                            ?>
                                                </div>
                                                <!-- ------ -->
                                                
                                            <?php  
                                            /*} */
                                        //}else{
                                         
                                        //}
                                    }
                                    //echo '<br>';
                                    
                                }
                                
                                
                               
                                
                                //// si el estado no está aprobado, no debería mostrar la trazabilidad de la eliminación
                                if($datosDoc['estadoElimina'] == 'Aprobado'){
                                ?>
                                <!-- ------ -->
                                <?php if($elaboraEliminacion != NULL){$verElaboraE="";}else{$verElaboraE="none";}?>
                                <div class="form-group col-sm-4" style="display:<?php echo $verElaboraE;?>">
                                    <label class="text-dark">Elabora eliminación: </label><br>
                                            <?php
                                                $elabora = json_decode($datosDoc['elaboraElimanar']);
                                                
                                                if($elabora[0] == 'cargos'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($elabora[0] == 'usuarios'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    } 
                                                }
                                            
                                            ?>
                                </div>
                                <!-- ------ -->
                                
                                <!-- ------ -->
                                <?php if($revisaEliminacion != NULL){$verRevisaE="";}else{$verRevisaE="none";}?>
                                <div class="form-group col-sm-4" style="display:<?php echo $verRevisaE;?>">
                                    <label class="text-dark">Revisa eliminación: </label><br>
                                            <?php
                                                $elabora = json_decode($datosDoc['revisaElimanar']);
                                                
                                                if($elabora[0] == 'cargos'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($elabora[0] == 'usuarios'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    } 
                                                }
                                            
                                            ?>
                                </div>
                                <!-- ------ -->
                                
                                
                                <!-- ------ -->
                                <?php if($apruebaEliminacion != NULL){$verApruebaE="";}else{$verApruebaE="none";}?>
                                <div class="form-group col-sm-4" style="display:<?php echo $verApruebaE;?>">
                                    <label class="text-dark">Aprueba eliminación: </label><br>
                                            <?php
                                                $elabora = json_decode($datosDoc['apruebaElimanar']);
                                                
                                                if($elabora[0] == 'cargos'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                    }            
                                                }
                                                
                                                if($elabora[0] == 'usuarios'){
                                                    $longitud = count($elabora);
                                                    
                                                    for($i=1; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                        $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$elabora[$i]'");
                                                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                        
                                                    	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                    } 
                                                }
                                            
                                            ?>
                                </div>
                                <!-- ------ -->
                                <?php
                                }
                                ?>
                                
                                <div class="form-group col-sm-6">
                                
                                </div>
                                
                                <div class="form-group col-sm-6">
                                
                                </div>
                            
                            </div>    
                                
                                
                            <div class="row post">
    
                            <div class="form-group col-sm-6">
                                <label class="text-dark">Archivo en gestión: </label><br>
                                <?php echo $datosDoc['archivo_gestion'];?>
                                <br>
                                
                                <label class="text-dark">Archivo central: </label><br>
                                <?php echo $datosDoc['archivo_central'];?>
                                <br>
                                
                                <label class="text-dark">Archivo histórico: </label><br>
                                <?php echo $datosDoc['archivo_historico'];?>
                                
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <?php
                                    //aca voy a validar si son usuarios o cargos los que se encargan de elaborar, revisar, aprobar            
                                    
                                       $resposableDispoDoc = json_decode($datosDoc['responsable_disposicion']);
                            
                            
                                        if($resposableDispoDoc[0] == 'cargos'){
                                            $checkedDispoC = "checked";            
                                        }
                                        
                                        if($resposableDispoDoc[0] == 'usuarios'){
                                            $checkedDispoU = "checked"; 
                                        }
    
                                        
                                ?>
                                
                                <label class="text-dark">Disposición Documental: </label><br>
                                <?php echo $datosDoc['disposicion_documental'];?><br>
                                <br>
                                <label class="text-dark">Responsable de disposición: </label><br>
                                        <?php
                                            //$respondableDispo = json_decode($datosDoc['responsable_disposicion']);
                                             $idDocumento.' - id <br>';
                                             'dato: '.$respondableDispo = json_decode($datosDoc['disposicionNombre']);
                                            if($respondableDispo[0] == 'cargos' || $respondableDispo[0] == 'usuarios'){    
                                                if($respondableDispo != NULL){    
                                                
                                                    if($respondableDispo[0] == 'cargos'){
                                                        $longitud = count($respondableDispo);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            echo "<strong>- </strong> ".$respondableDispo[$i]."<br>";
                                                            /*$queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$respondableDispo[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";*/
                                                        }            
                                                    }
                                                    
                                                    if($respondableDispo[0] == 'usuarios'){
                                                        $longitud = count($respondableDispo);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            echo "<strong>- </strong> ".$respondableDispo[$i]."<br>";
                                                            /*$queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$respondableDispo[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";*/
                                                        } 
                                                    }
                                                }
                                            }else{ 
                                               $respondableDispo = json_decode($datosDoc['responsable_disposicion']);
                                                if($respondableDispo[0] == 'cargos' || $respondableDispo[0] == 'usuarios'){    
                                                    if($respondableDispo != NULL){    
                                                    
                                                        if($respondableDispo[0] == 'cargos'){
                                                            $longitud = count($respondableDispo);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                                //saco el valor de cada elemento
                                                                //echo "<strong>- </strong> ".$respondableDispo[$i]."<br>";
                                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$respondableDispo[$i]'");
                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                
                                                            	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                            }            
                                                        }
                                                        
                                                        if($respondableDispo[0] == 'usuarios'){
                                                            $longitud = count($respondableDispo);
                                                            
                                                            for($i=1; $i<$longitud; $i++){
                                                                //saco el valor de cada elemento
                                                                //echo "<strong>- </strong> ".$respondableDispo[$i]."<br>";
                                                                $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$respondableDispo[$i]'");
                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                
                                                            	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                            } 
                                                        }
                                                    }
                                                }else{   
                                                     echo $datosDoc['responsable_disposicion'];
                                                }
                                            }
                                        ?>
                            </div>    
                            </div>
                            
                            <?php
                                $nombreOtro = $datosDoc['nombreOtro']; //nombreOtro
                                if($nombreOtro == NULL){
                                    $verOtro = "none";
                                }else{
                                    $rutaOtro = "archivos/documentos/".$nombreOtro;
                                }
                                
                                
                            ?>
                            
                            <div class="row post" style="display:<?php echo $verOtro;?>">
                            <!--
                            <div class="form-group col-sm-6">
                                <label class="text-dark">Documento editable: </label><br>
                                
                                <button type='button'  class='btn btn-block btn-warning btn-sm' >
                                    <a style='color:black' href='<?php //echo $rutaOtro;?>' target="_blank" ><i class='fas fa-download'></i> Descargar</a>
                                </button>
                                
                            </div>-->
                            
                            <div class="form-group col-sm-6">
                             </div>
                            </div>
                               
                               
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <!-- TABLA PERMISOS-->
    
    
    <?php
        if($datosDoc['nombrePDF'] != NULL){
    ?>
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Documento</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <?php
                                    $nombrePDF = $datosDoc['nombrePDF'];
                                ?>
                          <div class="card-body">
                              <div id="example1"></div>
                                
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <?php } ?>
    <!-- TABLA PERMISOS-->
    
    <?php
        if($datosDoc['metodo'] == "html"){
    ?>
    
    <!-- TABLA HTML-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Documento HTML</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <textarea name="editor1" required><?php echo $datosDoc['htmlDoc']; ?></textarea>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <?php } ?>
    <!-- TABLA HTML-->
    
    
    <!-- TABLA DEL CONTROL DE CAMBIO FORMAL-->
     <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Control de Cambios</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div style="padding: 20px;" class="tab-pane" id="timeline">
                                       
                                <?php   $idDocumento;
                                         
                                         
                                  if(isset($verObsoletos)){
                                       'obsoleto';
                                  }else{
                                        'listado';
                                  }      
                                         
                          
                            // consulta de la tabla del control de cambios
                               
                                
                                    // ahora sacamos la información del último control de cambio realiado
                                    //$consultandoFlujoControlCambios=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='$idDocumento' ");
                                    //$extraerConsultaFlujoControlCambios=$consultandoFlujoControlCambios->fetch_array(MYSQLI_ASSOC);
                                    //$informacionDelTexto=$extraerConsultaFlujoControlCambios['informacion']; // sacamos el id anterior
                                
                                 'Entra id: '.$_POST['idDocumento'];
                                    // ahora sacamos la información del último control de cambio realiado
                                
                                $consultandoDocumento=$mysqli->query("SELECT * FROm documento WHERE id='".$_POST['idDocumento']."' "); //enviarIdDocumento
                                $extraerConsultaDocumento=$consultandoDocumento->fetch_array(MYSQLI_ASSOC);
                                 'Id solicitud: '.$extraerIdSolicitud=$extraerConsultaDocumento['id_solicitud'];
                            
                            
                                $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='".$_POST['idDocumento']."' ");
                                $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
                                if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
                                    
                                    if($extrerSolicitudDocumento['tipoSolicitud'] == '3'){  '<br>Cuando está en una solicitud de eliminación.';
                                        if(isset($verObsoletos)){
                                            $informacionDelTexto=$extrarConsultaExistenciaComentario['informacion'];    
                                        }else{
                                            $informacionDelTexto=$extrarConsultaExistenciaComentario['comentarioAnterior']; 
                                        }
                                    }else{
                                        $informacionDelTexto=$extrarConsultaExistenciaComentario['informacion'];
                                    } 
                                    
                                    
                                }else{
                                
                                    $consultaControlCambios=$mysqli->query("SELECT * FROM  controlCambiosParametrizacion ");
                                    $extraerControlCambios=$consultaControlCambios->fetch_array(MYSQLI_ASSOC);
                                    $informacionDelTexto=$extraerControlCambios['informacion'];
                                }
    
                           
                            // end
                            ?>
                            <textarea name="editor12" readonly required><?php echo $informacionDelTexto;?></textarea>
                            </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <!-- END -->
    
    <!-- TABLA CONTROL DE CAMBIOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Comentarios</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                          <?php 
                                            
                                          
                                          ' - id principal '.$datosDoc['id'].'<br><br>';
                                        ///// realizamos el recorrido de los procesos para la tabla    
                                         '<br>Respaldo: '.$idRespaldoEnviar=$datosDoc['id_solicitudRespaldo'];
                                        '<br>';
                                        if($extrerSolicitudDocumento['tipoSolicitud'] == '3' && $datosDoc['estadoElimina'] == 'Rechazado'){
                                             'entra a la eliminación';
                                             ' - '.$datosDoc['id'];
                                             '<br>';
                                            
                                             '<br>';
                                            //// se pregunta si viene por vigente
                                            $preguntandoVigente=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='".$datosDoc['id_solicitudRespaldo']."' ");
                                            $resultadoPreguntaVigente=$preguntandoVigente->fetch_array(MYSQLI_ASSOC);
                                            $respuestaVigentePregunta=$resultadoPreguntaVigente['docVigente'];
                                            
                                            if($respuestaVigentePregunta == '1'){
                                                 'idA:----- '.$enviarIdConsultaContolrCambios=$datosDoc['id_solicitudRespaldo'];
                                                $recorridoContrtolCambios=$mysqli->query("SELECT * FROM controlCambios WHERE idDocumento='".$enviarIdConsultaContolrCambios."' GROUP BY idDocumento");
                                                
                                                while($extraerRecorridoRespaldo=$recorridoContrtolCambios->fetch_array()){
                                                    $extraerRecorridoRespaldo['id'];
                                                    /// sudconsulta de solicitudes
                                                     '<br><br>'.$extraerRecorridoRespaldo['idDocumento'];  '<br>';
                                                    $subConsultaSolicitudes=$mysqli->query("SELECT MAX(id) AS comentarios FROM solicitudDocumentos WHERE id='".$extraerRecorridoRespaldo['idDocumento']."' AND estado='Ejecutado' ORDER BY id DESC  ");
                                                    $extraerSubConsultaSoli=$subConsultaSolicitudes->fetch_array(MYSQLI_ASSOC);
                                                    $string.=($extraerSubConsultaSoli['comentarios']);
                                                }
                                                $newStrinG=trim($string);
                                                $idSol=$newStrinG;   
                                                 'este es: '.$idSol;
                                                
                                            }else{
                                                 'idB:----- '.$idSol=$datosDoc['id'];
                                                 $saleValidacionB=1;
                                            }
                                            
                                            $recorridoContrtolCambiosValidando=$mysqli->query("SELECT * FROM controlCambios WHERE idDocumento='".$idSol."' GROUP BY idDocumento");
                                            $extraerRecorridoRespaldoValidando=$recorridoContrtolCambiosValidando->fetch_array(MYSQLI_ASSOC);
                                             '<br>tipo: '.$validandoRespaldoRecorrido=$extraerRecorridoRespaldoValidando['tipoSolicitud'];
                                           
                                               
                                                
                                        }else{  
                                             '--id: soli: '.$extrerSolicitudDocumento['id'];
                                             if($extrerSolicitudDocumento['tipoSolicitud'] == '3'){
                                                  '<br>-- Entra a la solicitud para mantener los datos anterior: --<br>';
                                                 $idSol=$datosDoc['id'];
                                                 $saleValidacionElimnaYmantenerControl='1';
                                                 
                                             }else{
                                                    '<br>--id normal '.$idSol = $datosDoc['id_solicitud'];
                                             }
                                        }   
                                            
                                            
                                           
                                            
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            if($saleValidacionB == '1' && $validandoRespaldoRecorrido <> '1'){ 
                                                 'diferente a una id: '.$idSol;
                                                 '<br> tipo de solicitud: '.$validandoRespaldoRecorrido;
                                                    if($validandoRespaldoRecorrido == NULL){
                                                         '<br>Entra al Null con este id: '.$idRespaldoEnviar;
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idRespaldoEnviar'  ")or die(mysqli_error($mysqli)); //tipoSolicitud IS NULL
                                                        
                                                        if(mysqli_num_rows($queryControl) > 0 ){
                                                             '<br>Se ejecuta el SQL';
                                                        }else{
                                                             '<br>No se ejecuta el SQL'.$idSol;
                                                             '<br>tipo de solicitu: '.$extrerSolicitudDocumento['tipoSolicitud'];
                                                            $noEjecutaSql=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE nombreDocumento='$idSol' AND estado='Ejecutado' AND tipoSolicitud='2'  ORDER BY id DESC ");
                                                            $extraerNoEjecutaSql=$noEjecutaSql->fetch_array(MYSQLI_ASSOC);
                                                             '<br> Debe salir: '.$extraerNoEjecutaSql['id'];
                                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '".$extraerNoEjecutaSql['id']."'  ")or die(mysqli_error($mysqli)); //tipoSolicitud IS NULL
                                                        
                                                        }
                                                        
                                                        
                                                    }else{
                                                         '<br>No entra al Null';
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' AND tipoSolicitud ='1' ")or die(mysqli_error($mysqli)); //tipoSolicitud IS NULL
                                                    }
                                                }else{  
                                                 '<br>a buscar comentarios anteriores';
                                                if($saleValidacionElimnaYmantenerControl == 1){  
                                                     '-- con 1-';
                                                    if(isset($verObsoletos)){
                                                        /// prgeuntamos si viene NULL o NO NULL
                                                        $verificandoNull=$mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' AND tipoSolicitud='3' ");
                                                        while($respuestaVerificacionNull=$verificandoNull->fetch_array()){
                                                         'Desde obsoleto: '.$respuestaVerificacionNull['tipoSolicitud'];  '<br>';
                                                        }
                                                        /// END
                                                    }else{
                                                        /// prgeuntamos si viene NULL o NO NULL
                                                        $verificandoNull=$mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' ");
                                                        while($respuestaVerificacionNull=$verificandoNull->fetch_array()){
                                                         'Normal: '.$respuestaVerificacionNull['tipoSolicitud'];  '<br>';
                                                        }
                                                        /// END    
                                                    }
                                                
                                                    //$queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' AND tipoSolicitud IS NULL ")or die(mysqli_error($mysqli));
                                                     '<br> Id conslta: '.$idSol;
                                                    if(isset($verObsoletos)){
                                                    $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' AND tipoSolicitud ='3' ")or die(mysqli_error($mysqli));
                                                    }else{
                                                     '<br>Se rechaza el documento de eliminación después de aprobar una actualizaión id para rescatar: '.$idRescatarAprobadorActuaRechazarElimi=$datosDoc['id_solicitudRespaldo'];
                                                    
                                                    if($datosDoc['estadoActualiza'] == 'Aprobado'){
                                                     '<br>Con el estado aprobado: '.$idRescatarAprobadorActuaRechazarElimi;
                                                    
                                                    $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idRescatarAprobadorActuaRechazarElimi' AND tipoSolicitud IS NULL ")or die(mysqli_error($mysqli));
                                                    if(mysqli_num_rows($queryControl) > 0 ){
                                                             '<br>Se ejecuta el SQL segunda parte';
                                                        }else{
                                                             '<br>No se ejecuta el SQL segunda parte: '.$idSol;
                                                             '<br>tipo de solicitu: '.$extrerSolicitudDocumento['tipoSolicitud'];
                                                            $noEjecutaSql=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE nombreDocumento='$idSol' AND estado='Ejecutado' AND tipoSolicitud='2'  ORDER BY id DESC ");
                                                            $extraerNoEjecutaSql=$noEjecutaSql->fetch_array(MYSQLI_ASSOC);
                                                             '<br> Debe salir: '.$extraerNoEjecutaSql['id'];
                                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '".$extraerNoEjecutaSql['id']."'  ")or die(mysqli_error($mysqli)); //tipoSolicitud IS NULL
                                                        
                                                        }
                                                        
                                                        
                                                    }else{
                                                    $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' AND tipoSolicitud ='1' ")or die(mysqli_error($mysqli));
                                                    }
                                                        
                                                    }
                                                }else{  
                                                     '-- sin  1: '.$idSol; //idDocumento=$idSol 
                                                    if($datosDoc['estadoActualiza'] == 'Aprobado'){
                                                     '<br>Rescatando comentarios cuando el estado actualiza es aprobado :'.$idRespaldoEnviar;
                                                        if($idRespaldoEnviar != NULL){  '<br>Detecta que viene el id de respaldo';
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idRespaldoEnviar'  ")or die(mysqli_error($mysqli));    
                                                        }else{  '<br>El id de respaldo, viene vacio';
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idSol'  ")or die(mysqli_error($mysqli));    
                                                        }
                                                    }else{   '<br>Solicitud: '.$datosDoc['id_solicitud'];
                                                    $objeticvoVerificacion=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='".$datosDoc['id_solicitud']."' ");
                                                    $objetivoVerificacionporSiAca=$objeticvoVerificacion->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($datosDoc['estadoElimina'] == 'Rechazado' && $objetivoVerificacionporSiAca['estado'] == 'Rechazado'){
                                                         '<br>los 2 restados va rechazados';
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idRespaldoEnviar'  ")or die(mysqli_error($mysqli));
                                                    }else{
                                                         '<br>Estado normal';
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idSol'  ")or die(mysqli_error($mysqli));    
                                                    }
                                                    
                                                    
                                                        
                                                    }
                                                         
                                                }
                                                   
                                            }
                                            while($row = $queryControl->fetch_assoc()){
                                                $idUser = $row['idUsuario'];
                                                $rol = $row['rol'];
                                                if($idUser == null){
                                                    $nombreUsuario = $row['idUsuarioB'];
                                                    $rol = $row['rol'];
                                                    
                                                    
                                                    ////// si el id del usuario viene en número me debe consultar el usuario
                                                        $nombreUsuarioS=substr($nombreUsuario,0,-1);
                                                        
                                                        if(is_numeric($nombreUsuarioS)){
                                                            
                                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                            $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$nombreUsuario' ")or die(mysqli_error($mysqli));
                                                            $datosUser = $queryUser->fetch_assoc();
                                                            $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                            
                                                        }else{
                                                           $nombreUsuarioSale=$nombreUsuario;
                                                        }
                                                        
                                                    ///// end
                                                    
                                                    
                                                    
                                                    
                                                }else{
                                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                    $datosUser = $queryUser->fetch_assoc();
                                                    $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                }
                                          ?>
                                          
                                          <div class="time-label">
                                            <span class="bg-danger">
                                              <?php echo substr($row['fecha'],0,-8);?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              <?php
                                               $row['id'];
                                               $row['idDocumento'];
                                              ?>
                                              <h3 class="timeline-header border-0"><b><?php echo $rol?></b> - <a href="#"><?php if($row['nombre'] != NULL){ echo $row['nombre']; }else{ echo $nombreUsuarioSale; } ?></a> <?php echo nl2br($row['comentario']);?>
                                              </h3>
                                            </div>
                                          </div>
                                        <?php }
                                        ?>
                                        </div>
                                     </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <!-- TABLA TABLA CONTROL DE CAMBIOS--->
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

<!-- jQuery -->
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
    const MAXIMO_TAMANIO_BYTES = 11000000; // 1MB = 1 millón de bytes

// Obtener referencia al elemento
const $miInput = document.querySelector("#miInput");

$miInput.addEventListener("change", function () {
	// si no hay archivos, regresamos
	if (this.files.length <= 0) return;

	// Validamos el primer archivo únicamente
	const archivo = this.files[0];
	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
		const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
    
    
        Toast.fire({
            type: 'warning',
            title: ` El tamaño máximo del archivo es de 10 MB`
        })
		// Limpiar
		$miInput.value = "";
	} else {
		// Validación asada. Envía el formulario o haz lo que tengas que hacer
	}
});
</script>
<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- end -->
 <script>
                           ///// evento para la divulgación
                                $(document).ready(function(){ 
                                    $('#openDivulgacion').click(function(){ 
                                        document.getElementById('divulgacion').style.display = '';
                                    });
                                    $('#openFlujo').click(function(){ 
                                        document.getElementById('asignadosFlujo').style.display = '';
                                    });
                                     $('#rad_cargoAut').click(function(){ 
                                        document.getElementById('listarCargos').style.display = '';
                                        document.getElementById('listarUsuarios').style.display = 'none';
                                        document.getElementById('listarGrupos').style.display = 'none';
                                        
                                    });
                                    $('#rad_usuarioAut').click(function(){ 
                                        document.getElementById('listarUsuarios').style.display = '';
                                        document.getElementById('listarCargos').style.display = 'none';
                                        document.getElementById('listarGrupos').style.display = 'none';
                                       
                                    });
                                    $('#rad_grupoAut').click(function(){ 
                                        document.getElementById('listarGrupos').style.display = '';
                                        document.getElementById('listarUsuarios').style.display = 'none';
                                        document.getElementById('listarCargos').style.display = 'none';
                                       
                                    });
                                });
                                
                                
                                
                           ///// end
                          
                                    //var radioCargo = document.getElementsByName('radiobtnAut').;
                            /*
                            $(document).ready(function(){
                    	        $("#notificar").click(function() {	 
                        			contenidoRadio = $('input:radio[name=radiobtnAut]:checked').val();
                        			$("#formularioBotton").submit();
                        		    mostrarNombre();
                    			});
                    	    });
                    	    
                    	    function mostrarNombre(){
                              alert(contenidoRadio);
                                     
                                       
                                            if(contenidoRadio == 'cargo'){
                                             alert("Activar obligatorio Cargos"); 
                                             contenidoRadio;
                                             enviarParametro();
                                            }else if(contenidoRadio == 'usuario'){
                                             alert("Activar obligatorio usuario");   
                                            }else if(contenidoRadio == 'grupo'){
                                             alert("Activar obligatorio grupo");   
                                            }
                            }
                            
                            function v(s){
                                function enviarParametro(){
                                    alert("Entra parametro");
                                }
                            }                 
                              */             
                                       /* function v(s){
                                            
                                            
                                            
                                                if (s['select_encargadoAutA[]'].selectedIndex!=-1){
                                                    return true;
                                                }else{
                                                    //alert("Debes seleccionar al menos 1 opción");
                                                     const Toast = Swal.mixin({
                                                      toast: true,
                                                      position: 'top-end',
                                                      showConfirmButton: false,
                                                      timer: 3000
                                                    });
                                                    
                                                    
                                                    
                                                        Toast.fire({
                                                            type: 'warning',
                                                            title: ' Debe seleccionar al menos 1 opción A.'
                                                        })
                                                    return false;
                                                }
                                                
                                                
                                            
                                                if (s['select_encargadoAutB[]'].selectedIndex!=-1){
                                                    return true;
                                                }else{
                                                    //alert("Debes seleccionar al menos 1 opción");
                                                     const Toast = Swal.mixin({
                                                      toast: true,
                                                      position: 'top-end',
                                                      showConfirmButton: false,
                                                      timer: 3000
                                                    });
                                                    
                                                    
                                                    
                                                        Toast.fire({
                                                            type: 'warning',
                                                            title: ' Debe seleccionar al menos 1 opción B.'
                                                        })
                                                    return false;
                                                }
                                                
                                                if (s['select_encargadoAutC[]'].selectedIndex!=-1){
                                                    return true;
                                                }else{
                                                    //alert("Debes seleccionar al menos 1 opción");
                                                     const Toast = Swal.mixin({
                                                      toast: true,
                                                      position: 'top-end',
                                                      showConfirmButton: false,
                                                      timer: 3000
                                                    });
                                                    
                                                    
                                                    
                                                        Toast.fire({
                                                            type: 'warning',
                                                            title: ' Debe seleccionar al menos 1 opción C.'
                                                        })
                                                    return false;
                                                }
                                            
                                        }*/
                                    </script>
                                    
<?php
$validacionAgregar=$_POST['validacionAgregar'];
$validacionVacio=$_POST['validacionVacio'];
?>

  <script type="text/javascript">
    $(function() {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      
      
      <?php 
      if($validacionAgregar == 1){
      ?>
          Toast.fire({
              type: 'success',
              title: 'Divulgación enviada.'
          })
      <?php
      }
       if($validacionVacio == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: 'Debe seleccionar el personal de divulgación.'
          })
      <?php
      }
      
      
      if($validacionActualizar == 1){
      ?>
          Toast.fire({
              type: 'info',
              title: 'Registro actualizado.'
          })
      <?php
      }
      ?>
      
    });

  </script>



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
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoD').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        $('#rad_usuarioD').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        
        /* Aca se carga los datos que ya se an seleccioando*/            
        var radios = document.getElementsByName('radiobtnD');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radEncargadoDD = "radEncargadoDD";
            
            //alert(rad_post);
            
            $.post("selectDocumentos2.php", { rad_post: rad_post, grupo: grupo, radEncargadoDD: radEncargadoDD}, function(data){
                $("#select_encargadoD").html(data);
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
    CKEDITOR.replace( 'editor12' );
</script>
<script>PDFObject.embed("archivos/documentos/<?php echo $nombrePDF;?>", "#example1");</script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>