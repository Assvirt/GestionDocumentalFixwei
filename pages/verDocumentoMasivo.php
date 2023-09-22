<?php 
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require 'conexion/bd.php';
$acentos = $mysqli->query("SET NAMES 'utf8'");
$idDocumento = $_POST['idDocumento'];
$queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
$datosDoc = $queryDoc->fetch_assoc();

$elaboraEliminacion = $datosDoc['elaboraElimanar'];
$revisaEliminacion = $datosDoc['revisaElimanar'];
$apruebaEliminacion = $datosDoc['apruebaElimanar'];

$elaboraActualizar = $datosDoc['elaboraActualizar'];
$revisaActualizar = $datosDoc['revisaActualizar'];
$apruebaActualizar = $datosDoc['apruebaActualizar'];

$verObsoletos = $_POST['obsoletooss'];//$_POST['verObsoletos'];


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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="crearDocumentoMasivoObsoleto"><font color="white"><i class="fas fa-list"></i> Documento obsoleto</font></a></button>
                        </div>
                        
                        <?php 
                            }else{
                                ?>
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="crearDocumentoMasivo"><font color="white"><i class="fas fa-list"></i> Documento masivo</font></a></button>
                        </div>
                        
                        <?php
                            }
                        ?>
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
                
           
            </div>
        <div>

        </div>
      </div><!-- /.container-fluid -->
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
                                            $resultado=$mysqli->query("SELECT * FROM tipoDocumento ORDER BY nombre");
                                        
                                            while ($columna = mysqli_fetch_array( $resultado )) {
                                                if($datosDoc['tipo_documento'] == $columna['id']){
                                                    echo $columna['nombre'];
                                                }
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
                                    <?php echo $datosDoc['ubicacion']; ?>
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
                                        $arrayNormas = json_decode($datosDoc['norma']);
                                    ?>
                                    <label class="text-dark">Normas: </label><br>
                                      
                                        <?php
                                        
                                            if(!$arrayNormas){
                                                echo "Sin normas";    
                                            }else{
                                                while ($columna = mysqli_fetch_array( $resultado )) { 
                                                    if(in_array($columna['id'],$arrayNormas)){
                                                    $seleccionarNorm = "selected";
                                                    echo"<strong>- </strong>".$columna['nombre']; echo "<br>";
                                                    }
                                                }
                                            }
                                        
                                           
                                            
                                        ?>
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <?php
                                    require_once'conexion/bd.php';
                                    $resultado=$mysqli->query("SELECT id, nombre FROM documentoExterno");
                                    $arrayDocE = json_decode($datosDoc['documento_externo']);
                                    ?>
                                    <label class="text-dark">Documentos externos: </label><br>
                                        <?php
                                        if(!$arrayDocE){
                                            echo "Sin documentos externos.";
                                        }else{
                                            while ($columna = mysqli_fetch_array( $resultado )) {
                                                if(in_array($columna['id'],$arrayDocE)){
                                                    echo"<strong>- </strong> ".$columna['nombre']; echo "<br>";        
                                                }
                                            }
                                        }
                                             
                                        ?>
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <?php
                                    require_once'conexion/bd.php';
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultado=$mysqli->query("SELECT id, nombre FROM definicion");
                                    $arrayDefiniciones = json_decode($datosDoc['definiciones']);
                                    ?>
                                    <label class="text-dark">Definiciones: </label><br>
                                        <?php
                                            
                                            if(!$arrayDefiniciones){
                                                echo "Sin definiciones.";
                                            }else{
                                                while ($columna = mysqli_fetch_array( $resultado )) { 
                                                    if(in_array($columna['id'],$arrayDefiniciones)){
                                                        echo"<strong>- </strong> ".$columna['nombre']; echo "<br>";         
                                                    }
                                                }
                                            }
                                        
                                            
                                        ?> 
                                </div>
                                
                                
                               
                                <div class="form-group col-sm-6">
                                
                                </div>
                                
                                <div class="form-group col-sm-6">
                                
                                </div>
                            
                            </div>
                            <!--FIN ROW-->
                            
                            
                            <div class="row post">
                                
                               
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Elabora creación: </label><br>
                                            <?php 
                                                $elabora = json_decode($datosDoc['elabora']);
                                               
                                                
                                                if($elabora[0] == 'cargos' || $elabora[0] == 'usuarios'){
                                                    
                                                
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
                                                            $elabora;
                                                            //exit;
                                                            $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$elabora[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            //$nombres['nombres'];
                                                        	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                        } 
                                                    }
                                                }else{
                                                    echo $datosDoc['elabora'];
                                                }
                                            ?>
                                </div>
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Revisa creación: </label><br>
                                    <?php
                                    $revisa = json_decode($datosDoc['revisa']);
                                   
                                        if($revisa[0] == 'cargos' || $revisa[0] == 'usuarios'){
                                            if($revisa[0] == 'cargos'){
                                                $longitud = count($revisa);
                                                
                                                for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisa[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                   /*
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$revisa[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                   */
                                                	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                }            
                                            }
                                            //echo 'Aqui';
                                            if($revisa[0] == 'usuarios'){
                                                $longitud = count($revisa);
                                                
                                                for($i=1; $i<$longitud; $i++){
                                                    //saco el valor de cada elemento
                                                    $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$revisa[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                	//echo "<strong>- </strong> 'AAAAAA'<br>";
                                                } 
                                            }
                                        }else{
                                            echo $datosDoc['revisa'];
                                        }
                                    ?>
                                </div>
                                
                                
                                <div class="form-group col-sm-4">
                                    <label class="text-dark">Aprueba creación: </label><br>
                                    <?php
                                     $aprueba = json_decode($datosDoc['aprueba']);
                                    if($aprueba[0] == 'cargos' || $aprueba[0] == 'usuarios'){ 
                                        if($aprueba[0] == 'cargos'){
                                            $longitud = count($aprueba);
                                            
                                            for($i=1; $i<$longitud; $i++){
                                                //saco el valor de cada elemento
                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$aprueba[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                
                                            	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                            }            
                                        }
                                        
                                        if($aprueba[0] == 'usuarios'){ 
                                            $longitud = count($aprueba);
                                            
                                            for($i=1; $i<$longitud; $i++){
                                                //saco el valor de cada elemento
                                                $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$aprueba[$i]'");
                                                    $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                    
                                                	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                            } 
                                        }
                                    }else{
                                        echo $datosDoc['aprueba'];
                                    }
                                    ?>
                                </div>
                                
                                <!-- ------ -->
                                <?php if($elaboraActualizar != NULL){$verElaboraA="";}else{$verElaboraA="none";}?>
                                <div class="form-group col-sm-4" style="display:<?php echo $verElaboraA;?>">
                                    <label class="text-dark">Elabora actualización: </label><br>
                                            <?php
                                                $elabora = json_decode($datosDoc['elaboraActualizar']);
                                                
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
                                <?php if($revisaActualizar != NULL){$verRevisaA="";}else{$verRevisaA="none";}?>
                                <div class="form-group col-sm-4" style="display:<?php echo $verRevisaA;?>">
                                    <label class="text-dark">Revisa actualización: </label><br>
                                            <?php
                                                $elabora = json_decode($datosDoc['revisaActualizar']);
                                                
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
                                <?php if($apruebaActualizar != NULL){$verApruebaA="";}else{$verApruebaA="none";}?>
                                <div class="form-group col-sm-4" style="display:<?php echo $verApruebaA;?>">
                                    <label class="text-dark">Arpueba actualización: </label><br>
                                            <?php
                                                $elabora = json_decode($datosDoc['apruebaActualizar']);
                                                
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
                                            $respondableDispo = json_decode($datosDoc['responsable_disposicion']);
                                            if($respondableDispo[0] == 'cargos' || $respondableDispo[0] == 'usuarios'){    
                                                if($respondableDispo != NULL){    
                                                
                                                    if($respondableDispo[0] == 'cargos'){
                                                        $longitud = count($respondableDispo);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$respondableDispo[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<strong>- </strong> ".$nombres['nombreCargos']."<br>";
                                                        }            
                                                    }
                                                    
                                                    if($respondableDispo[0] == 'usuarios'){
                                                        $longitud = count($respondableDispo);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            $queryNombres = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$respondableDispo[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<strong>- </strong> ".$nombres['nombres']." ".$nombres['apellidos']."<br>";
                                                        } 
                                                    }
                                                }
                                            }else{
                                                echo $datosDoc['responsable_disposicion'];
                                            }
                                        ?>
                            </div>    
                            </div>
                            
                            <?php
                                //$nombreOtro = $datosDoc['nombreOtro']; //nombreOtro
                                //if($nombreOtro == NULL){
                                    //$verOtro = "none";
                                //}else{
                                    //$rutaOtro = "archivos/documentos/".$nombreOtro;
                                //}
                                
                                
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
                                    // validamos si el documento está bien
                                    $preguntadoValidacion=$mysqli->query("SELECT * FROM documento WHERE  id='$idDocumento' ");
                                    $extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                                         ' - '.$documentoExtraidoPdf=($extraerPreguntaValidacion['nombrePDF']);
                                        
                                                		    
                                      '<br>';
                                      '<br>';
        		                    $carpeta="archivos/documentos/";
                                    $ruta="/".$carpeta."/";
                                    $directorio=opendir($carpeta);
                                    //recoger los  datos
                                    $datos=array();
                                    $conteoArchivosB=0;
                                    while ($archivo = readdir($directorio)) { 
                                      if(($archivo != '.')&&($archivo != '..')){
                                                             
                                        
                                        if($documentoExtraidoPdf == $datos[]=$archivo){
                                            $conteoArchivosB++;
                                             $datos[]=$archivo;  '<br>';
                                        }
                                        
                                                             
                                                             
                                      } 
                                    }
                                    closedir($directorio);
                                                            
                                    if($conteoArchivosB > 0){
                                       $documentoHabilitado2='1'; 
                                    }else{
                                       $documentoHabilitado2='no coincide';
                                    }
                                    if($documentoHabilitado2 > 0){
                                        
                                    }else{
                                        
                                    ?><!--  return checkSubmit();-->
                                                            <script>
                                                                $(document).ready(function() {
                                                                  // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                                                                  // cargado la pagina
                                                                  setTimeout(clickbutton, 0000);
                                                                
                                                                  function clickbutton() {
                                                                    // simulamos el click del mouse en el boton del formulario
                                                                    $("#action-button-bloqueado").click();
                                                                    //alert("Aqui llega"); //Debugger
                                                                  }
                                                                  $('#action-button-bloqueado').on('click',function() {
                                                                   // console.log('action');
                                                                  });
                                                                });
                                                            </script> 
                                                           <span id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></span>
                                                        
                                                            <div class="modal fade" id="modal-danger-alerta-Bloqueo">
                                                                <div class="modal-dialog">
                                                                  <div class="modal-content bg-danger">
                                                                    <div class="modal-header">
                                                                      <h4 class="modal-title">Alerta</h4>
                                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                      </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                      <p>El nombre del archivo contiene caracteres inválidos, por favor digite el nombre completo del archivo e intente cargar.</p>
                                                                    </div>
                                                                     <!-- END formulario para eliminar por el id -->
                                                                  </div>
                                                                </div>
                                                            </div>
                                    
                                    <?php
  
                                    }
                                    ///// END
                            
                            
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
                               
                                 'Entra id: '.$_POST['idDocumento'];
                                    // ahora sacamos la información del último control de cambio realiado
                                   $consultandoDocumento=$mysqli->query("SELECT * FROm documento WHERE id='".$_POST['idDocumento']."' "); //enviarIdDocumento
                                $extraerConsultaDocumento=$consultandoDocumento->fetch_array(MYSQLI_ASSOC);
                                 'Id solicitud: '.$extraerIdSolicitud=$extraerConsultaDocumento['id_solicitud'];
                            
                            
                                $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='".$_POST['idDocumento']."' ");
                                $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
                                if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
                                   
                                    $informacionDelTexto=$extrarConsultaExistenciaComentario['informacion'];
                                    
                                }else{
                                
                                    $consultaControlCambios=$mysqli->query("SELECT * FROM  controlCambiosParametrizacion ");
                                    $extraerControlCambios=$consultaControlCambios->fetch_array(MYSQLI_ASSOC);
                                    $informacionDelTexto=$extraerControlCambios['informacion'];
                                }
                                
    
                           
                            // end
                            ?>
                             <textarea disabled name="editor12" required><?php echo $informacionDelTexto;?></textarea>
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
                                            $idSol = $datosDoc['id_solicitud'];
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idSol' ")or die(mysqli_error($mysqli));
                                            
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
                                                    
                                                    <h3 class="timeline-header border-0"><b><?php echo $rol?></b> - <a href="#"><?php echo $nombreUsuarioSale?></a> <?php  if($row['comentario'] != NULL){ echo $row['comentario']; }else{ echo 'N/A';} ?>
                                                    </h3>
                                                    </div>
                                                </div>
                                                <?php
                                            }
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