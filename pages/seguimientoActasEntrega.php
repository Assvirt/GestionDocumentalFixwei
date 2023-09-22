<?php
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];


?>
<!DOCTYPE html> 
<html>
<head><meta charset="gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Seguimiento acta</title>
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
  <!-- summernote -->
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
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
<body class="hold-transition sidebar-mini" onload="nobackbutton();" oncopy="return false" onpaste="return false">
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
            <h1>Seguimiento acta</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Seguimiento acta</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="actas"><font color="white"><i class="fas fa-list"></i> Listar Actas</font></a></button>
                        </div>
                        <div class="col-sm">
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
                
           
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <?php
        $idActa = $_POST['idActa'];
        $nombreCompromiso = $_POST['nombreCompromiso'];
                    $nombrePlantilla = $_POST['id'];
                    $acta = $mysqli->query("SELECT * FROM actas WHERE id = '$idActa' ");
                    $aprobacion = $col['aprobacionCompromisos'];
                    while($col = $acta->fetch_assoc()) { 
                        $nombreActa = $col['nombreActa'];
                        $aprobacion = $col['aprobacionCompromisos'];
                        $compromisosGrupo = $col['compromisos'];
                        $compromisosID = json_decode($col['compromisosID']);
                        if($longitudArprueba != NULL){
                            $longitudArprueba = count($compromisosID);
                        }
                    }
    ?>
    
    
    
    
    <!-- COMPROMISOS-->
    
    <?php 
        $compromisos = $mysqli->query("SELECT * FROM compromisos WHERE idActa = '$idActa' AND compromiso LIKE '%$nombreCompromiso%' ORDER BY id ASC");
    ?>
    
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  
                  <div class="col-12">
                    <!-- Default box -->
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Acta: <strong><?php echo $nombreActa; ?></strong></h3>
                      </div>
                      <div class="card-body">
                        <div class="">
                            <?php
                                $n = 1;
                                while($col = $compromisos->fetch_assoc()) {
                                    $idCompromiso = $col['id'];
                                    $compromiso = $col['compromiso'];
                                    $responsableCompromiso = $col['responsableCompromiso'];
                                    $responsableCompromisoID =  json_decode($col['responsableID']);
                                    $longitud11 = count($responsableCompromisoID);
                                    $fechaPrimera =  $col['fechaEntrega'];
                                    $fechaFormato = date('Y/m/d h:i A', strtotime($fechaPrimera));
                                    $entregarA = $col['entregarA'];
                                    $entregarAID =  json_decode($col['entregarAID']);
                                    $longitud12 = count($entregarAID);
                                    $estado = $col['estado'];
                                     
                                     
                                    
                                    $accionesResponsable = "none";
                                    $accionesEvalua = "none";
                                    
                                    //Logica para hacer visible los campos de cuandola persona quentra es a encargada de un compromiso y debe subirlo 
                                    
                                    
                                   
                                    
                                    if($responsableCompromiso == "usuario"){
                                        if(in_array($idUsuario,$responsableCompromisoID)){
                                            $accionesResponsable = "";
                                            $requiredResponsable = "required";
                                        }
                                    }
                                    
                                    
                                    if($responsableCompromiso == "cargo"){
                                        if(in_array($cargoID,$responsableCompromisoID)){
                                            $accionesResponsable = "";
                                            $requiredResponsable = "required";
                                        }
                                    }
                                    
                                    
                                    
                                    //Logica para activar las acciones cuando entra el encargado de revisar los compromisos
                                    $validnadoEntregarA=FALSE;
                                    if($entregarA == "usuario"){
                                        if(in_array($idUsuario,$entregarAID)){
                                            $accionesEvalua = "";
                                            $requiredAccion = "required";
                                            $validnadoEntregarA=TRUE;
                                        }
                                    }
                                    if($entregarA == "cargo"){
                                        if(in_array($cargoID,$entregarAID)){
                                            $accionesEvalua = "";
                                            $requiredAccion = "required";
                                            $validnadoEntregarA=TRUE;
                                        }
                                    }
                                    
                                    if($validnadoEntregarA == TRUE){
                                        $mostrar='si';
                                    }else{
                                        $mostrar='no';
                                    }
                                    
                                    //var_dump($responsableCompromisoID);
                                   
                             if($mostrar == 'si'){       
                            ?>
                            <div class="border border-primary rounded" style="margin: 5px; padding:5px;">
                            
                            <div class="row">
                                
                                <div class="form-group col-md-12">
                                    <h3>Compromiso N° <?php echo $n;?></h3>
                                </div>
                            
                                <div class="form-group col-md-6">
                                    <label>Detalles del compromiso:</label><br>
                                    <span><?php echo $compromiso;?></span>
                                    
                                    
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Estado:</label><br>
                                    <span><?php 
                                            // preguntamos el estado del compromiso
                                            $preguntandoEstadoCompromiso=$mysqli->query("SELECT * FROM compromisosIndividuales WHERE id_compromiso='$idCompromiso' ");
                                            $extraerPreguntandoEstadoCompromiso=$preguntandoEstadoCompromiso->fetch_array(MYSQLI_ASSOC);
                                            if($extraerPreguntandoEstadoCompromiso['estado'] == 'Rechazado'){
                                                echo $extraerPreguntandoEstadoCompromiso['estado'];    
                                            }else{
                                                echo $estado;
                                            }
                                          ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Fecha entrega:</label><br>
                                    <span><?php echo $fechaFormato;?></span>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label>Entregar a: </label><br>
                                        <?php 
                                            if($entregarA == 'usuario'){
                                                
                                                for($i=0; $i<$longitud12; $i++){
                                                    
                                                    $nombreuser12 = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$entregarAID[$i]'");
                                                    $columna12 = $nombreuser12->fetch_array(MYSQLI_ASSOC);
                                                
                                                    echo $columna12['nombres']." ".$columna12['apellidos'];echo "<br>";
                                                    $enviarIdUsuarioEntrega=$columna12['id'];
                                                }
                                             
                                            }else{
                                                
                                                for($i=0; $i<$longitud12; $i++){
                                                $nombrecargo12 = $mysqli->query("SELECT nombreCargos,id_cargos FROM cargos WHERE id_cargos = '$entregarAID[$i]'");
                                                $columna12 = $nombrecargo12->fetch_array(MYSQLI_ASSOC);
                                                echo $columna12['nombreCargos'];echo "<br>";
                                                $enviarCargoEntrega=$columna12['id_cargos'];
                                                }
                                            }
                                            
                                        ?>
                                </div>
                            </div>
                            
                            <div class="row ">
                                <div class="col"></div>
                                <div class="form-group col-sm-12">
                                    <div class="card">
                                      <div class="card-header">
                                        <h3 class="card-title">Responsables del compromiso</h3>
                                      </div>
                                      <!-- /.card-header -->
                                      <div class="card-body p-0">
                                        <table class="table table-condensed text-center">
                                          <thead>
                                            <tr>
                                              <th style="width: 10px">#</th>
                                              <th>Responsable</th>
                                              <th>Estado</th>
                                              <th colspan="2" style="display:<?php echo $accionesEvalua;?>;">Acciones</th>
                                              <?php /* ?><th style="display:<?php echo $accionesResponsable;?>;" >Acciones</th> 
                                              <th style="display:<?php echo $accionesResponsable;?>;" colspan="2">Subir evidencia</th><? */ ?>
                                              <th>Descargar</th>
                                              <th>Comentarios</th>
                                              <th>Agregar</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                                
                                                <?php 
                                                    if($responsableCompromiso == 'usuario'){
                                                        $numx = 1;
                                                        
                                                        //// variable para desabilitar el botón agregar
                                                        $botonAgregarDisabled1=1;
                                                        $botonAgregarDisabled2=1;
                                                        $botonAgregarDisabled3=1;
                                                        $botonAgregarDisabled4=1;
                                                        $botonAgregarDisabled5=1;
                                                        
                                                        for($i=0; $i<$longitud11; $i++){
                                                            
                                                            $nombreuser11 = $mysqli->query("SELECT nombres, apellidos,id FROM usuario WHERE id = '$responsableCompromisoID[$i]' ");
                                                            $columna11 = $nombreuser11->fetch_array(MYSQLI_ASSOC);
                                                        
                                                            $nombreResponsable = $columna11['nombres']." ".$columna11['apellidos'];
                                                            $comparaIDUsuario=$columna11['id'];
                                                            if($responsableCompromisoID[$i] == $idUsuario){
                                                                $activaUpload = "";
                                                                $activaAcciones = "";
                                                            }else{
                                                                $activaUpload = "disabled";
                                                                $activaAcciones = "disabled";
                                                            }
                                                            
                                                            ////Aca voy a traer los datos de la subida del compromiso individual, el archivo/s subidos y el estado del compromiso
                                                            $disabledDownload = "disabled";
                                                            
                                                            $queryArhivo = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$responsableCompromisoID[$i]' ORDER BY id DESC");
                                                            $datosArchivo = $queryArhivo->fetch_array(MYSQLI_ASSOC);
                                                            $existeArchivo = $datosArchivo['rutaAvance'];
                                                            utf8_decode($rutaArchivo = "archivos/compromisos/acta".$idActa."/".$datosArchivo['rutaAvance']);
                                                            $estadoCompromiso = $datosArchivo['estado']; 
                                                            
                                                            if($estadoCompromiso == NULL){
                                                                $estadoCompromiso = "Pendiente";
                                                            }
                                                            
                                                            if($existeArchivo != NULL){
                                                                $disabledDownload = "";
                                                            }else{
                                                                $disabledDownload = "disabled";
                                                            }
                                                            
                                                            ?>
                                                                <form action="controlador/actas/controller" method="POST" enctype="multipart/form-data">
                                                                    <input name="nombreCompromiso" value="<?php echo $nombreCompromiso;?>" type="hidden">                                                                        
                                                                <tr>
                                                                    
                                                                        <td><?php echo $numx;?></td>
                                                                        <td><?php echo $nombreResponsable; ?></td>
                                                                        <td><font color="blue"><?php echo $estadoCompromiso;?></font></td>
                                                                        <?php
                                                                        if($estadoCompromiso == 'Avance' || $estadoCompromiso == 'Pendiente' || $estadoCompromiso == 'Rechazado'){
                                                                        ?>
                                                                        <td style="display:<?php echo $accionesEvalua;?>;"><label><input type="radio"  name="radbtnEstado" value="Aprobado" disabled> Aprobar</label></td>
                                                                        <td style="display:<?php echo $accionesEvalua;?>;"><label><input type="radio"  name="radbtnEstado" value="Rechazado" disabled> Rechazar</label></td>
                                                                        <?php    
                                                                        }else{
                                                                        ?>
                                                                        <td style="display:<?php echo $accionesEvalua;?>;"><label><input type="radio" id="aprobacionB" name="radbtnEstado" value="Aprobado" <?php echo $requiredAccion; ?>> Aprobar</label></td>
                                                                        <td style="display:<?php echo $accionesEvalua;?>;"><label><input type="radio" id="rechazadoB"  name="radbtnEstado" value="Rechazado" <?php echo $requiredAccion; ?>> Rechazar</label></td>
                                                                        <?php
                                                                        }
                                                                        /*
                                                                        ?>
                                                                        <td style="display:<?php echo $accionesResponsable;?>;">
                                                                            <select name="estado" class="form-control" <?php echo $requiredResponsable;?> <?php echo $activaAcciones;?>>
                                                                                <option value="" >Seleccione Opción</option>
                                                                                <option value="Avance">Avance</option>
                                                                                <option value="Ejecutado">Ejecutado</option>
                                                                            </select>
                                                                        </td>
                                                                        <td colspan="2" style="display:<?php echo $accionesResponsable;?>;">
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file" id="miInput" class="custom-file-input" name="archivo" <?php echo $activaUpload;?> <?php echo $requiredResponsable;?>>
                                                                                    <label class="custom-file-label" >Subir Archivo</label>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <?php
                                                                        */
                                                                        ?>
                                                                        <td>
                                                                            <?php
                                                                            if($disabledDownload == 'disabled'){
                                                                            ?>
                                                                            <button type='button'  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                                                                
                                                                                <a style='color:black'  ><i class='fas fa-download'></i> Descargar evidencia</a>
                                                                            </button>
                                                                            <?php
                                                                            }else{
                                                                            ?>
                                                                            <button type='button'  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                                                                
                                                                                <a style='color:black' href='<?php echo $rutaArchivo;?>' target="_blank"><i class='fas fa-download'></i> Descargar evidencia</a>
                                                                            </button>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        
                                                                        
                                                                        <td>
                                                                            <!--datos para almacenar los comentarios-->
                                                                            <textarea class="form-control" name="controlCambioC" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"></textarea>
                                                                            <input type="hidden" name="estadoComentarioActaC" id="resultado" value="<?php echo $_POST['estadoComentarioActa']; ?>">
                                                                            <input type="hidden" name="idCompromisoC" value="<?php echo $idCompromiso;?>">
                                                                            <input type="hidden" name="estadoC" value="<?php echo $estado;?>">
                                                                            <!--datos para almacenar los comentarios-->
                                                                        </td>
                                                                        
                                                                        
                                                                        
                                                                        <?php
                                                                        if($estadoCompromiso == 'Ejecutado'){
                                                                        ?>
                                                                        <td><button class="btn btn-primary btn-sm " type="submit" id="compromisoIndividualB<?php echo $botonAgregarDisabled1++;?>" name="compromisoIndividual" ><i class='fas fa-sync'></i> Agregar</button>
                                                                            <button style="display:none;" class="btn btn-primary btn-sm" id="compromisoIndividualBDisabled<?php echo $botonAgregarDisabled2++;?>" disabled ><i class='fas fa-sync'></i> Agregar</button>
                                                                                <script>
                                                                                    $(document).ready(function(){
                                                                                        $('#compromisoIndividualB<?php echo $botonAgregarDisabled3++;?>').click(function(){
                                                                                            document.getElementById('compromisoIndividualB<?php echo $botonAgregarDisabled4++;?>').style.display = 'none';
                                                                                            document.getElementById('compromisoIndividualBDisabled<?php echo $botonAgregarDisabled5++;?>').style.display = '';
                                                                                        });
                                                                                    });
                                                                                </script>
                                                                        </td>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <td><button class="btn btn-primary btn-sm " type="submit" disabled><i class='fas fa-sync'></i> Agregar</button></td>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <input type="hidden" name="responsableCompromiso" value="<?php echo $responsableCompromiso;?>">
                                                                        <input type="hidden" name="responsableCompromisoID" value="<?php echo $responsableCompromisoID[$i];?>">
                                                                        <input type="hidden" name="idCompromiso" value="<?php echo $idCompromiso;?>">
                                                                        <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                                                                    
                                                                </tr>
                                                                </form>
                                                            <?php
                                                            $numx++;
                                                        }
                                                     
                                                    }else{//Este elese es para cuando los responsables son cargo.
                                                        
                                                        $numx = 1;
                                                        
                                                        //// variable para desabilitar el botón agregar
                                                        $botonAgregarDisabled1=1;
                                                        $botonAgregarDisabled2=1;
                                                        $botonAgregarDisabled3=1;
                                                        $botonAgregarDisabled4=1;
                                                        $botonAgregarDisabled5=1;
                                                        
                                                        for($i=0; $i<$longitud11; $i++){
                                                        $nombrecargo11 = $mysqli->query("SELECT nombreCargos,id_cargos FROM cargos WHERE id_cargos = '$responsableCompromisoID[$i]'");
                                                        $columna11 = $nombrecargo11->fetch_array(MYSQLI_ASSOC);
                                                        $nombreResponsable = $columna11['nombreCargos'];
                                                        $enviarIdCargo=$columna11['id_cargos'];
                                                        
                                                            if($responsableCompromisoID[$i] == $cargoID){
                                                                $activaUpload = "";
                                                                $activaAcciones = "";
                                                            }else{
                                                                $activaUpload = "disabled";
                                                                $activaAcciones = "disabled";
                                                            }
                                                            
                                                            
                                                            
                                                            $queryArhivo = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$responsableCompromisoID[$i]' ORDER BY id DESC");
                                                            $datosArchivo = $queryArhivo->fetch_array(MYSQLI_ASSOC);
                                                            $existeArchivo = $datosArchivo['rutaAvance'];
                                                            $estadoCompromiso = $datosArchivo['estado']; 
                                                            utf8_decode($rutaArchivo = "archivos/compromisos/acta".$idActa."/".$datosArchivo['rutaAvance']);
                                                            
                                                            if($estadoCompromiso == NULL){
                                                                $estadoCompromiso = "Pendiente";
                                                            }
                                                            
                                                            if($existeArchivo != NULL){
                                                                $disabledDownload = "";
                                                            }else{
                                                                $disabledDownload = "disabled";
                                                            }
                                                            
                                                            ?>
                                                                <tr>
                                                                    <form action="controlador/actas/controller" method="POST" enctype="multipart/form-data">
                                                                        <input name="nombreCompromiso" value="<?php echo $nombreCompromiso;?>" type="hidden">
                                                                        <td><?php echo $numx;?></td>
                                                                        <td><?php echo $nombreResponsable;?></td>
                                                                        <td><font color="blue"><?php echo $estadoCompromiso;?></font></td>
                                                                        <?php
                                                                        if($estadoCompromiso == 'Avance' || $estadoCompromiso == 'Pendiente' || $estadoCompromiso == 'Rechazado'){
                                                                        ?>
                                                                        <td style="display:<?php echo $accionesEvalua;?>;"><label><input type="radio" name="radbtnEstado" value="Aprobado" disabled >Aprobar</label></td>
                                                                        <td style="display:<?php echo $accionesEvalua;?>;"><label><input type="radio" name="radbtnEstado" value="Rechazado" disabled >Rechazar</label></td>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <td style="display:<?php echo $accionesEvalua;?>;"><label><input type="radio" name="radbtnEstado" value="Aprobado" <?php echo $requiredAccion; ?>>Aprobar</label></td>
                                                                        <td style="display:<?php echo $accionesEvalua;?>;"><label><input type="radio" name="radbtnEstado" value="Rechazado" <?php echo $requiredAccion; ?>>Rechazar</label></td>
                                                                        <?php
                                                                        }
                                                                        /*
                                                                        ?>
                                                                        <td style="display:<?php echo $accionesResponsable;?>;">
                                                                            <select name="estado" class="form-control"  <?php echo $activaAcciones;?> <?php echo $requiredResponsable;?>>
                                                                                <option value="">Seleccione Opción</option>
                                                                                <option value="Avance">Avance</option>
                                                                                <option value="Ejecutado">Ejecutado</option>
                                                                            </select>
                                                                        </td>
                                                                        <td colspan="2" style="display:<?php echo $accionesResponsable;?>;">
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file" id="miInput2" class="custom-file-input" name="archivo" <?php echo $activaUpload;?> <?php echo $requiredResponsable;?>>
                                                                                    <label class="custom-file-label" >Subir Archivo</label>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <?php
                                                                        */
                                                                        ?>
                                                                        <td>
                                                                            <?php
                                                                            if($disabledDownload == 'disabled'){
                                                                            ?>
                                                                             <button type='button'  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                                                                <a style='color:black' ><i class='fas fa-download'></i> Descargar evidencia</a>
                                                                             </button>
                                                                            <?php
                                                                            }else{
                                                                            ?>
                                                                            <button type='button'  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                                                                
                                                                                <a style='color:black' href='<?php echo $rutaArchivo;?>' target="_blank" ><i class='fas fa-download'></i> Descargar evidencia</a>
                                                                            </button>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        
                                                                        
                                                                        <td>
                                                                            <!--datos para almacenar los comentarios-->
                                                                            <textarea class="form-control" name="controlCambioC" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"></textarea>
                                                                            <input type="hidden" name="estadoComentarioActaC" id="resultado" value="<?php echo $_POST['estadoComentarioActa']; ?>">
                                                                            <input type="hidden" name="idCompromisoC" value="<?php echo $idCompromiso;?>">
                                                                            <input type="hidden" name="estadoC" value="<?php echo $estado;?>">
                                                                            <!--datos para almacenar los comentarios-->
                                                                        </td>
                                                                        
                                                                        <?php
                                                                        if($estadoCompromiso == 'Ejecutado'){
                                                                        ?>
                                                                        <td><button class="btn btn-primary btn-sm" type="submit" id="compromisoIndividualB<?php echo $botonAgregarDisabled1++;?>" name="compromisoIndividual" ><i class='fas fa-sync'></i> Agregar</button>
                                                                            <button style="display:none;" class="btn btn-primary btn-sm" id="compromisoIndividualBDisabled<?php echo $botonAgregarDisabled2++;?>" disabled ><i class='fas fa-sync'></i> Agregar</button>
                                                                                <script>
                                                                                    $(document).ready(function(){
                                                                                        $('#compromisoIndividualB<?php echo $botonAgregarDisabled3++;?>').click(function(){
                                                                                            document.getElementById('compromisoIndividualB<?php echo $botonAgregarDisabled4++;?>').style.display = 'none';
                                                                                            document.getElementById('compromisoIndividualBDisabled<?php echo $botonAgregarDisabled5++;?>').style.display = '';
                                                                                        });
                                                                                    });
                                                                                </script>
                                                                        
                                                                        
                                                                        </td>
                                                                        <?php
                                                                        }else{
                                                                        ?>
                                                                        <td><button class="btn btn-primary btn-sm" disabled ><i class='fas fa-sync'></i> Agregar</button></td>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <input type="hidden" name="responsableCompromiso" value="<?php echo $responsableCompromiso;?>">
                                                                        <input type="hidden" name="responsableCompromisoID" value="<?php echo $responsableCompromisoID[$i];?>">
                                                                        <input type="hidden" name="idCompromiso" value="<?php echo $idCompromiso;?>">
                                                                        <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                                                                    </form>
                                                                </tr>
                                                                
                                                            <?php
                                                            $numx++; 
                                                        
                                                        }
                                                    }
                                                    
                                                ?>
                                          </tbody>
                                        </table>
                                      </div>
                                      <!-- /.card-body -->
                                    </div>
                                    <!-- /.card --> 
                                </div>
                                <div class="col"></div>
                            </div>
                            
                            <form action="controlador/actas/controller" method="POST" enctype="multipart/form-data">
                                
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        
                                        
                                        <div class="card-body">
                                            <div style="padding: 20px;" class="tab-pane" id="timeline">
                                                        <!-- The timeline -->
                                                        <div class="timeline timeline-inverse">
                                                          <!-- timeline time label -->
                                                          <?php 
                                                            $idSol = $datosDoc['id_solicitud'];
                                                            $queryControl = $mysqli->query("SELECT * FROM controlCambiosCompromisos WHERE idCompromiso = $idCompromiso AND primerComentario='1' ")or die(mysqli_error($mysqli));
                                                            
                                                            while($row = $queryControl->fetch_assoc()){
                                                                $idUser = $row['usuario'];
                                                                $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                                $datosUser = $queryUser->fetch_assoc();
                
                                                                $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                                
                                                          ?>
                                                          
                                                          <div class="time-label">
                                                            <span class="bg-danger">
                                                              <?php echo substr($row['fecha'],0,-8);//$row['fecha']?>
                                                            </span>
                                                          </div>
                
                                                          <div>
                                                            <i class="fas fa-user bg-info"></i>
                                    
                                                            <div class="timeline-item">
                                                              
                                                              <h3 class="timeline-header border-0"><a href="#">
                                                                  <?php echo $nombreUsuario?></a> <?php echo $row['comentario']?>
                                                              </h3>
                                                            </div>
                                                          </div>
                                                          
                                                          <?php
                                                          /// validamos que la respuesta sea igual del dirigido al id del responsable listado
                                                          $validar_respuesta=$mysqli->query("SELECT * FROM controlCambiosCompromisos WHERE idCompromiso = $idCompromiso  ORDER BY id "); //AND dirigido='".$datosUser['id']."'
                                                          while($extraer_validar_respuesta=$validar_respuesta->fetch_array()){
                                                              if($extraer_validar_respuesta['id'] != NULL){
                                                                  
                                                                  
                                                                if($extraer_validar_respuesta['dirigido'] == $datosUser['id']){
                                                                  /// traemos le nombre de la persona que dirigio una respuesta
                                                                  $quien_dirigio=$mysqli->query("SELECT nombres,apellidos,cedula FROM usuario WHERE cedula='".$extraer_validar_respuesta['usuario']."' ");
                                                                  $extraer_quien_dirigio=$quien_dirigio->fetch_array(MYSQLI_ASSOC);
                                                                  $nombreUsuario_quien_dirije=$extraer_quien_dirigio['nombres'].' '.$extraer_quien_dirigio['apellidos'];
                                                              ?>
                                                                  <div>
                                                                    <div class="timeline-item" style="margin-left:90px;">
                                                                      
                                                                      <h3 class="timeline-header border-0"><a href="#">
                                                                          <?php echo $nombreUsuario_quien_dirije;?></a> <?php echo $extraer_validar_respuesta['comentario'];?>
                                                                      </h3>
                                                                    </div>
                                                                  </div>
                                                              <?php
                                                                }elseif($extraer_validar_respuesta['usuario'] == $row['usuario']  && $extraer_validar_respuesta['dirigido'] == NULL && $extraer_validar_respuesta['primerComentario'] == NULL){
                                                                  /// traemos le nombre de la persona que dirigio una respuesta
                                                                  $quien_dirigio=$mysqli->query("SELECT nombres,apellidos,cedula FROM usuario WHERE cedula='".$extraer_validar_respuesta['usuario']."' ");
                                                                  $extraer_quien_dirigio=$quien_dirigio->fetch_array(MYSQLI_ASSOC);
                                                                  $nombreUsuario_quien_dirije=$extraer_quien_dirigio['nombres'].' '.$extraer_quien_dirigio['apellidos'];
                                                                ?>
                                                                  <div>
                                                                    <div class="timeline-item" style="margin-left:90px;">
                                                                      
                                                                      <h3 class="timeline-header border-0"><a href="#">
                                                                          <?php echo $nombreUsuario_quien_dirije;?></a> <?php echo $extraer_validar_respuesta['comentario'];?>
                                                                      </h3>
                                                                    </div>
                                                                  </div>
                                                              <?php    
                                                                }
                                                                
                                                                
                                                              
                                                              
                                                              }
                                                          }
                                                          ?>
                                                          
                                                        <?php }?>
                                                        </div>
                                                     </div>
                                          </div>
                                    </div>
                                    
                                    
                                </div>
                                
                            </form>
                            
                            </div>
                            <?php $n++; /*FIN WHILE COMPROMISOS*/ 
                                 
                             }else{
                                    
                                }
                                 
                             }
                            
                                
                            ?>
                        
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
    <!-- COMPROMISOS-->
    
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
<script type="text/javascript">

        //
        
        $(document).ready(function(){
            $('#aprobacionB').click(function(){ 
               document.getElementById("resultado").value = document.getElementById("aprobacionB").value; 
            });
             $('#rechazadoB').click(function(){ 
               document.getElementById("resultado").value = document.getElementById("rechazadoB").value; 
            });
            
        });    

</script>
<script>
    const MAXIMO_TAMANIO_BYTES = 2000000; // 1MB = 1 millón de bytes

// Obtener referencia al elemento
const $miInput = document.querySelector("#miInput");

$miInput.addEventListener("change", function () {
	// si no hay archivos, regresamos
	if (this.files.length <= 0) return;

	// Validamos el primer archivo únicamente
	const archivo = this.files[0];
	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
		alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
		// Limpiar
		$miInput.value = "";
	} else {
		// Validación asada. Envía el formulario o haz lo que tengas que hacer
	}
});
const $miInput2 = document.querySelector("#miInput2");

$miInput2.addEventListener("change", function () {
	// si no hay archivos, regresamos
	if (this.files.length <= 0) return;

	// Validamos el primer archivo únicamente
	const archivo = this.files[0];
	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
		alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
		// Limpiar
		$miInput2.value = "";
	} else {
		// Validación asada. Envía el formulario o haz lo que tengas que hacer
	}
});
</script>
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
<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>


<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
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
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nivel o la prioridad ya existe.'
        })
    <?php
    }
    
    if($validacionAgregar == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Registro agregado.'
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
    
    if($validacionEliminar == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'Registro eliminado.'
        })
    
    <?php
    }
    ?>
    
  });

</script>
<script type="text/javascript">
$(document).ready(function () {
   
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
   
    $("body").on("contextmenu",function(e){
        return false;
    });
});
</script>
</body>
</html>
<?php
}
?>