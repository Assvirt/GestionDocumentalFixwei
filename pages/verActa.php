<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';


$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];

require 'conexion/bd.php';
$idActa = $_POST['idActa'];
$acentos = $mysqli->query("SET NAMES 'utf8'");
$actaNombreActaDocumento = $mysqli->query("SELECT * FROM actas WHERE id = '$idActa' ");
while($colNombreActaDocumento = $actaNombreActaDocumento->fetch_assoc()) { 
    $nombreActaDocumento = $colNombreActaDocumento['nombreActa'];
}
?>
<!DOCTYPE html> 
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Acta <?php echo $nombreActaDocumento;?></title>
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
  <script>
        CKEDITOR.plugins.addExternal( 'save-to-pdf', 'https://rawgit.com/Api2Pdf/api2pdf.ckeditor4/master/plugins/save-to-pdf/', 'plugin.js' );
    </script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
   <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script>
    function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
}
    
</script>
<style>
    .page {table-layout:fixed; width: 21cm; min-height: 29.7cm; padding: 2cm; margin: 1cm auto; border: 1px #D3D3D3 solid; border-radius: 5px; background: white; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); }
    

</style>

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
  <?php  require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header border-1">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ver acta</h1>
            <br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver acta</li>
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
                            </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  
             <div class="row">
            
                  <style>
                            .card.card-body{ border:none; }

                             .btn-primary.focus, .btn-primary:focus { box-shadow:unset !important;}
                             
                             .btn.focus, .btn:focus{ box-shadow:unset !important;}
                    </style>
                
             
                
                <div class="invoice p-3 mb-3">
                  <!-- Table row -->
                  <div class="row">
                    <div class="col-12 table-responsive">
                      
                                <?php
                                if($idEncabezado != NULL){
                                    $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE id = '2' ");
                                    //$ConsultaOrdenCompra = $mysqli->query("SELECT * FROM ");
                                    $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                                    echo $encabezado['encabezado'];
                                    
                                }else{
                                    $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE principal = '2' ");
                                    $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                                    echo $encabezado['encabezado'];
                                    
                                }
                                
                                ?>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.información del  acta -->
                  <?php
                            $idActa = $_POST['idActa'];
                            $nombrePlantilla = $_POST['id'];
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $acta = $mysqli->query("SELECT * FROM actas WHERE id = '$idActa' ");
                            while($col = $acta->fetch_assoc()) { 
                                $nombreActa = $col['nombreActa'];
                                $proceso = $col['proceso'];
                                $ubicacion = $col['ubicacion'];
                                $fechaini = $col['fechaInicio'];
                                $fechaCierre = $col['fechaCierre'];
                                $quienCita = $col['quienCita'];
                                $quienCitaID =  json_decode($col['quienCitaID']); 
                                //var_dump($quienCitaID);
                                $longitud = count($quienCitaID);
                                $quienElabora = $col['quienElabora'];
                                $quienElaboraID = json_decode($col['quienElaboraID']);
                                $longitud2 = count($quienElaboraID);
                                $aprobacion = $col['aprobacionCompromisos'];
                                $compromisos = $col['compromisos'];
                                $compromisosID = json_decode($col['compromisosID']);
                                ///acta requiere arpovacion 
                                $radioActaSiNO = $col['aprobarActa'];//requiere compromisos
                                $radioActaTipo = $col['quienAprueba'];//quien compromisos
                                $selectActaAprobacion = json_decode($col['quienApruebaId']);
                                $longitudActas = count($selectActaAprobacion);
                                
                                if($compromisosID != NULL){
                                    $longitud3 = count($compromisosID);
                                }
                                $convocados = $col['convocado'];
                                $convocadosID = json_decode($col['convocadoID']);
                                $convocadosID2 = json_decode($col['convocadoID']);
                                $longitud4 = count($convocadosID);
                                $asistentes = $col['asistente'];
                                $asistentesID = json_decode($col['asistenteID']);
                                $longitud5 = count($asistentesID);
                                //aqui va todo lo de EXTERNOS
                                $jsonConvocado = json_decode($col['nombreConvocadoEXT']);
                                if($jsonConvocado != NULL){
                                    $longitud6 = count($jsonConvocado);
                                }
                                $jsonTipo = json_decode($col['tipoEmpresaCovEXT']);
                                if($jsonTipo != NULL){
                                    $longitud7 = count($jsonTipo);
                                }
                                $jsonNombre = json_decode($col['nombreEmpresa']);
                                if($jsonNombre != NULL){
                                    $longitud8 = count($jsonNombre);
                                }
                                $jsonCargo = json_decode($col['cargoConvocadoEXT']);
                                //var_dump($jsonCargo);
                                if($jsonCargo != NULL){
                                    $longitud9 = count($jsonCargo);
                                }
                                
                                ///////
                                
                                $permisoActa = $col['permisosActa'];  /// usuario, grupo o cargo
                                $publico = $col['publico'];  // si o no
                                $responsablesID = json_decode($col['responsablesActa']); 
                                if($responsablesID != NULL){
                                    $longitud10 = count($responsablesID);
                                }
                                $editor = $col['acta'];
                                $comentario = $col['comentario'];
                                $estado = $col['estado'];
                                $idEncabezado=$col['idEncabezado'];
                                $idEncabezadoPlantilla=$col['idEncabezadoPlantilla'];
                            }
            
            ?>
                  <div class="container-fluid">
                        <!-- /.row -->
                         <div class="card-body">    
                         <div class="row">
                            <div class="col">
                            </div>
                            <div class="col-12"></div>
                           
                              
                              <!-- /.card-header -->
                              <!-- form start -->
                              
                                <div class="" style="background:white;"> <!-- class="card-body" page se retira esta propiedad de la class para quitar el borde -->
                                    <div class="row" id="" style="text-align:justify;">
                                        
                                        <div class="form-group col-md-" style="align:center;width:100%;">
                                           
                                                <?php
                                                if($idEncabezado != NULL){
                                                    $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE id = '$idEncabezado' ");
                                                    $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                                                    echo $encabezado['encabezado'];
                                                }else{
                                                    $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE principal = '1' ");
                                                    $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                                                    echo $encabezado['encabezado'];
                                                }
                                                
                                                ?>
                                           
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                           <label for="">Nombre:</label>
                                           <?php echo $nombreActa; ?>
                                        </div>
                
                                        <div class="form-group col-md-6">
                                            <label>Proceso:</label>
                                            
                                             <?php
                                            
                                             require 'conexion/bd.php';
                                             $acentos = $mysqli->query("SET NAMES 'utf8'");
                                             $resultado = $mysqli->query("SELECT * FROM procesos ORDER BY id");
                                             while($row = $resultado->fetch_assoc()) { 
                    				            if($row['id'] == $proceso){
                    				                $selectPro = "selected";
                    				                echo $row['nombre'];
                    				            }
                    				        } 
                    				            
                    				        ?>
                                            
                                        </div>
                
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputPassword1">Ubicación:</label>
                                            <?php echo $ubicacion; ?>
                                            
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                         
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputPassword1">Fecha y hora de inicio:</label>
                                            <?php echo date('Y/m/d h:i A', strtotime($fechaini));?>
                                           
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputPassword1">Fecha y hora de cierre:</label>
                                            <?php echo date('Y/m/d h:i A', strtotime($fechaCierre));?>
                                            
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Quién Cita: </label><br>
                                            <label for="usuarios"><?php  $quienCita;?></label>
                                            
                                                <?php 
                                                if($quienCita == 'usuario'){
                                                    
                                                    for($i=0; $i<$longitud; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $nombreuser = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienCitaID[$i]'");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    
                                                        echo $columna['nombres']." ".$columna['apellidos'];echo "<br>";
                                                     
                                                    }
                                                 
                                                }else{
                                                    
                                                    for($i=0; $i<$longitud; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienCitaID[$i]'");
                                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                    echo $columna['nombreCargos'];echo "<br>";
                                                    }
                                                }
                                                
                                                ?>
                                                
                                            
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Quién Elabora: </label><br>
                                           <p>
                                                <?php 
                                                if($quienElabora == 'usuario'){
                                                    
                                                    for($i=0; $i<$longitud2; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $nombreuser2 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienElaboraID[$i]'");
                                                        $columna2 = $nombreuser2->fetch_array(MYSQLI_ASSOC);
                                                    
                                                        echo $columna2['nombres']." ".$columna2['apellidos'];echo "<br>";
                                                     
                                                    }
                                                 
                                                }else{
                                                    
                                                    for($i=0; $i<$longitud2; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $nombrecargo2 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraID[$i]'");
                                                    $columna2 = $nombrecargo2->fetch_array(MYSQLI_ASSOC);
                                                    echo $columna2['nombreCargos'];echo "<br>";
                                                    }
                                                }
                                                
                                                ?>
                                                
                                            </p>
                                        </div>
                                       
                                        <div class="form-group col-md-6">
                                            <label>¿El acta necesita de aprobación? : </label><br>
                                            <?php
                                            if($radioActaSiNO == 'si'){
                                                echo "Si";
                                            ?>
                                            
                                            
                                            <p>
                                                <?php 
                                                if($radioActaTipo == 'usuario'){
                                                    
                                                    for($i=0; $i<$longitudActas; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $nombreuser3 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$selectActaAprobacion[$i]'");
                                                        $columna3 = $nombreuser3->fetch_array(MYSQLI_ASSOC);
                                                    
                                                        echo $enviarNombreRechazo=$columna3['nombres']." ".$columna3['apellidos'];echo "<br>";
                                                     
                                                    }
                                                 
                                                }else{
                                                    
                                                    for($i=0; $i<$longitudActas; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $nombrecargo3 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$selectActaAprobacion[$i]'");
                                                    $columna3 = $nombrecargo3->fetch_array(MYSQLI_ASSOC);
                                                    echo $enviarNombreRechazo=$columna3['nombreCargos'];echo "<br>";
                                                    }
                                                }
                                                
                                                ?>
                                                
                                            </p>
                                            <?php
                                            }else{
                                                echo "No";
                                            }
                                            ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Estado del acta: </label><br>
                                            <?php
                                            
                                                echo $estado;
                                            ?>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Convocados: </label><br>
                                            <p>
                                                <?php 
                                                if($convocados == 'usuario'){
                                                    
                                                    for($i=0; $i<$longitud4; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $nombreuser4 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$convocadosID[$i]'");
                                                        $columna4 = $nombreuser4->fetch_array(MYSQLI_ASSOC);
                                                    
                                                        echo $columna4['nombres']." ".$columna4['apellidos'];echo "<br>";
                                                     
                                                    }
                                                 
                                                }else{
                                                    
                                                    for($i=0; $i<$longitud4; $i++){
                                                        //echo $convocadosID2[$i];
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $nombrecargo4 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$convocadosID2[$i]'");
                                                    $columna4 = $nombrecargo4->fetch_array(MYSQLI_ASSOC);
                                                    echo $columna4['nombreCargos'];echo "<br>";
                                                    }
                                                }
                                                
                                                ?>
                                                
                                            </p>
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-6">
                                            <label>Asistentes: </label><br>
                                            <p>
                                                <?php 
                                                if($asistentes == 'usuario'){
                                                    
                                                    for($i=0; $i<$longitud5; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $nombreuser5 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$asistentesID[$i]'");
                                                        $columna5 = $nombreuser5->fetch_array(MYSQLI_ASSOC);
                                                    
                                                        echo $columna5['nombres']." ".$columna5['apellidos'];echo "<br>";
                                                     
                                                    }
                                                 
                                                }else{
                                                    
                                                    for($i=0; $i<$longitud5; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $nombrecargo5 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$asistentesID[$i]'");
                                                    $columna5 = $nombrecargo5->fetch_array(MYSQLI_ASSOC);
                                                    echo $columna5['nombreCargos'];echo "<br>";
                                                    }
                                                }
                                                
                                                ?>
                                                
                                            </p>
                                        </div>
                                        
                                        <?php
                                        /// preguntamos si existe registro en convocado
                                        
                                        if($jsonConvocado == ",,,,,,,,,"){ }else{
                                        ?>
                                        <div class="form-group col-md-12">
                                            <label for="">Convocados Externos:</label>
                                            <div class="row">
                                                <div class="col-3">   
                                                <label for="">Nombres:</label><br>
                                                <?php
                                                $arrayConvocados = explode(',',$jsonConvocado);
                                                foreach($arrayConvocados as $convocado){
                          
                                                    if($convocado == ''){
                                                        continue;
                                                    }else{
                                                        echo $convocado;echo"<br>";  
                                                    }
                                                    
                                                }
                                                
                                                ?>
                                                </div>
                                                <div class="col-3">
                                                <label for="">Tipos Empresa:</label><br>
                                                <?php
                                                $arrayTipo = explode(',',$jsonTipo);
                                                foreach($arrayTipo as $tipo){
                          
                                                    if($tipo == ''){
                                                        continue;
                                                    }else{
                                                      echo $tipo;echo"<br>";  
                                                    }
                                                    
                                                }
                                                
                                                ?>
                                                </div>
                                                <div class="col-3">
                                                <label for=""> Empresa:</label><br>
                                                <?php
                                                $arrayEmpresaNombre = explode(',',$jsonNombre);
                                                foreach($arrayEmpresaNombre as $nombreE){
                          
                                                    if($nombreE == ''){
                                                        continue;
                                                    }else{
                                                      echo $nombreE;echo"<br>";  
                                                    }
                                                    
                                                }
                                                
                                                
                                                ?>
                                                </div>
                                                <div class="col-3">
                                                <label for="">Cargo:</label><br>
                                                <?php
                                                $arrayCargos = explode(',', $jsonCargo);
                                                //print_r($arrayCargos);
                                                //echo $longitud9;
                                                foreach($arrayCargos as $cargo){
                          
                                                    if($cargo == ''){
                                                        continue;
                                                    }else{
                                                      echo $cargo;echo"<br>";  
                                                    }
                                                    
                                                }
                                                
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        } 
                                        /// end
                                        ?>
                                        
                                        
                                        <div class="form-group col-md-"> <!-- 12 -->
                                            <label>¿Acta abierta a todo público? : </label><br>
                                            <?php
                                            if($publico == 'no'){
                                                echo "No";
                                            ?>
                                            <br>
                                            <label>Autorizados para visualizar: </label><br>
                                            
                                                <?php 
                                                if($permisoActa == 'usuario'){
                                                    
                                                    for($i=0; $i<$longitud10; $i++){
                                                        
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $nombreuser6 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$responsablesID[$i]'");
                                                        $columna6 = $nombreuser6->fetch_array(MYSQLI_ASSOC);
                                                    
                                                        echo $columna6['nombres']." ".$columna6['apellidos'];echo "<br>";
                                                     
                                                    }
                                                 
                                                }elseif($permisoActa == 'grupo'){
                                                    
                                                    
                                                    for($i=0; $i<$longitud10; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $nombrecargo6 = $mysqli->query("SELECT nombre FROM grupo WHERE id = '$responsablesID[$i]'");
                                                    $columna6 = $nombrecargo6->fetch_array(MYSQLI_ASSOC);
                                                    echo $columna6['nombre'];echo "<br>";
                                                    }
                                                }
                                                else{
                                                    
                                                    
                                                    for($i=0; $i<$longitud10; $i++){
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $nombrecargo6 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$responsablesID[$i]'");
                                                    $columna6 = $nombrecargo6->fetch_array(MYSQLI_ASSOC);
                                                    echo $columna6['nombreCargos'];echo "<br>";
                                                    }
                                                }
                                                
                                                ?>
                                                
                                            
                                            <?php
                                            }else{
                                                echo "Si";
                                            }
                                            ?>
                                            <br>
                                            <label>Seguimiento del acta: </label>
                                            
                                            
                                            <?php
                                             $consultaSeguimiento = $mysqli->query("SELECT * FROM actas WHERE id = '$idActa'");
                                             $extraerContenidoActa = $consultaSeguimiento->fetch_array(MYSQLI_ASSOC);
                                             $contenidoDelActa = $extraerContenidoActa['acta'];
                                             echo $contenidoDelActa;
                                            
                                            ?>
                                                
                                        </div>
                                        
                                        
                                        <?php 
                                        
                                        $permitidoEstado = FALSE;
                                        $permisoEditar = FALSE;
                
                
                                            if($quienElabora == 'usuario'){
                                                if(in_array($idUsuario,$quienElaboraID)){
                                                    $permisoEditar = TRUE;
                                                }
                                            }
                                            
                                            if($quienElabora == 'cargo'){
                                                if(in_array($cargoID,$quienElaboraID)){
                                                    $permisoEditar = TRUE;
                                                }   
                                            }
                                                
                                            if($radioActaSiNO == "si"){
                                                if($radioActaTipo == 'usuario'){
                                                    for($i=0; $i<$longitudActas; $i++){
                                                        
                                                        if($idUsuario == $selectActaAprobacion[$i]){
                                                            $permitidoEstado = TRUE;
                                                        }
                                                        
                                                    }
                                                    
                                                }
                                                
                                                if($radioActaTipo == 'cargo'){
                                                    for($i=0; $i<$longitudActas; $i++){
                                                        
                                                        if($cargoID == $selectActaAprobacion[$i]){
                                                            $permitidoEstado = TRUE;
                                                        }
                                                        
                                                    }
                                                }
                                            }
                                        
                                            
                                        
                                        ?>
                                        
                                        
                                        <div class="form-group col-sm-12" >
                                            <div id="canvas_div_pdf" name="canvas_div_pdf"  ><?php  $editor; ?></div>
                                        </div> 
                                        
                
                                        
                                </div>
                               
                                
                    <?php
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $compromisos = $mysqli->query("SELECT * FROM compromisos WHERE idActa = '$idActa' ORDER BY id ASC");
                    ?>
                    
                    <section class="content">
                        <div class="container-fluid">
                                <div class="row">
                                    <div class="col"></div>
                                  
                                  <div class="col-12">
                                    <!-- Default box -->
                                      <div class="card-body">
                                       
                                        <center><h3>Compromisos</h3></center>
                                      </div>
                                      <div class="card-body">
                                        <div class="row">
                                            <?php
                                            $n = 1;
                                                while($col = $compromisos->fetch_assoc()) {
                                                    $compromiso = $col['compromiso'];
                                                    $responsableCompromiso = $col['responsableCompromiso'];
                                                    $responsableCompromisoID =  json_decode($col['responsableID']);
                                                    $longitud11 = count($responsableCompromisoID);
                                                    $fechaPrimera =  $col['fechaEntrega'];
                                                    $fechaFormato = date('Y/m/d h:i A', strtotime($fechaPrimera));
                                                    
                                                    $entregarA = $col['entregarA'];
                                                    $entregarAID =  json_decode($col['entregarAID']);
                                                    $longitud12 = count($entregarAID);
                                                    $estadoCompromiso=$col['estado'];
                                                    
                                            ?>
                                            <div class="col-md-12 " style="margin: 10px; padding:10px;"> <!-- class="border border-primary rounded"-->
                                                
                                                <div class="form-group col-md-6">
                                                    <h3>Compromiso N° <?php echo $n;?></h3>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Detalles del compromiso:</label><br>
                                                        <span><?php echo $compromiso;?></span>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-6">
                                                        <label>Estado:</label><br>
                                                        <span><?php echo $estadoCompromiso;?></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <label>Responsable: </label><br>
                                                        <p>
                                                                <?php 
                                                                if($responsableCompromiso == 'usuario'){
                                                                    
                                                                    for($i=0; $i<$longitud11; $i++){
                                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                        $nombreuser11 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$responsableCompromisoID[$i]'");
                                                                        $columna11 = $nombreuser11->fetch_array(MYSQLI_ASSOC);
                                                                    
                                                                        
                                                                                    $idCompromiso=$col['id'];
                                                                                    $queryArhivo = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$responsableCompromisoID[$i]' ORDER BY id DESC");
                                                                                    $datosArchivo = $queryArhivo->fetch_array(MYSQLI_ASSOC);
                                                                                    $existeArchivo = $datosArchivo['rutaAvance'];
                                                                                    utf8_decode($rutaArchivo = "archivos/compromisos/acta".$idActa."/".$datosArchivo['rutaAvance']);
                                                                                    $estadoCompromiso = $datosArchivo['estado'];
                                                                    
                                                                            echo $columna11['nombres']." ".$columna11['apellidos'];  echo "<br><br>"; 
                                                                    }
                                                                 
                                                                }else{
                                                                    
                                                                    for($i=0; $i<$longitud11; $i++){
                                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                    $nombrecargo11 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$responsableCompromisoID[$i]'");
                                                                    $columna11 = $nombrecargo11->fetch_array(MYSQLI_ASSOC);
                                                                    
                                                                    
                                                                                    $idCompromiso=$col['id'];
                                                                                    $queryArhivo = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$responsableCompromisoID[$i]' ORDER BY id DESC");
                                                                                    $datosArchivo = $queryArhivo->fetch_array(MYSQLI_ASSOC);
                                                                                    $existeArchivo = $datosArchivo['rutaAvance'];
                                                                                    utf8_decode($rutaArchivo = "archivos/compromisos/acta".$idActa."/".$datosArchivo['rutaAvance']);
                                                                                    $estadoCompromiso = $datosArchivo['estado'];
                                                                    
                                                                    
                                                                            echo $columna11['nombreCargos'];echo "<br><br>";
                                                                            
                                                                    }
                                                                }
                                                                
                                                                ?>
                                                                
                                                            </p>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Descargar: </label><br>
                                                        <p>
                                                                <?php 
                                                                if($responsableCompromiso == 'usuario'){
                                                                    
                                                                    for($i=0; $i<$longitud11; $i++){
                                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                        $nombreuser11 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$responsableCompromisoID[$i]'");
                                                                        $columna11 = $nombreuser11->fetch_array(MYSQLI_ASSOC);
                                                                    
                                                                        
                                                                                    $idCompromiso=$col['id'];
                                                                                    $queryArhivo = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$responsableCompromisoID[$i]' ORDER BY id DESC");
                                                                                    $datosArchivo = $queryArhivo->fetch_array(MYSQLI_ASSOC);
                                                                                    $existeArchivo = $datosArchivo['rutaAvance'];
                                                                                    utf8_decode($rutaArchivo = "archivos/compromisos/acta".$idActa."/".$datosArchivo['rutaAvance']);
                                                                                    $estadoCompromiso = $datosArchivo['estado'];
                                                                    
                                                                          
                                                                              if($datosArchivo['rutaAvance'] != NULL){
                                                                              ?>
                                                                              <button type='button'  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                                                                <a style='color:black' href='<?php echo $rutaArchivo;?>' target="_blank"><i class='fas fa-download'></i> Descargar evidencia</a>
                                                                              </button>
                                                                             <?php
                                                                              }else{
                                                                             ?>
                                                                             <button disabled  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                                                                <a style='color:black'><i class='fas fa-download'></i> Descargar evidencia</a>
                                                                             </button>
                                                                             <?php
                                                                              }
                                                                              echo "<br><br>";
                                                                            
                                                                    }
                                                                 
                                                                }else{
                                                                    
                                                                    for($i=0; $i<$longitud11; $i++){
                                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                        $nombrecargo11 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$responsableCompromisoID[$i]'");
                                                                        $columna11 = $nombrecargo11->fetch_array(MYSQLI_ASSOC);
                                                                    
                                                                    
                                                                                    $idCompromiso=$col['id'];
                                                                                    $queryArhivo = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$responsableCompromisoID[$i]' ORDER BY id DESC");
                                                                                    $datosArchivo = $queryArhivo->fetch_array(MYSQLI_ASSOC);
                                                                                    $existeArchivo = $datosArchivo['rutaAvance'];
                                                                                    utf8_decode($rutaArchivo = "archivos/compromisos/acta".$idActa."/".$datosArchivo['rutaAvance']);
                                                                                    echo $estadoCompromiso = $datosArchivo['estado'];
                                                                    
                                                                   
                                                                           
                                                                    if($datosArchivo['rutaAvance'] != NULL){
                                                                    ?>
                                                                    <button type='button'  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                                                        <a style='color:black' href='<?php echo $rutaArchivo;?>' target="_blank"><i class='fas fa-download'></i> Descargar evidencia</a>
                                                                    </button>
                                                                    <?php
                                                                    }else{
                                                                    ?>
                                                                    <button disabled  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                                                        <a style='color:black'><i class='fas fa-download'></i> Descargar evidencia</a>
                                                                    </button>         
                                                                             
                                                                    <?php
                                                                    }
                                                                    echo "<br><br>";
                                                                    }
                                                                }
                                                                
                                                                ?>
                                                                
                                                            </p>
                                                    </div>
                                                 </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Fecha entrega:</label><br>
                                                        <span><?php echo $fechaFormato;?></span>
                                                    </div>
                                                    
                                                    <div class="form-group col-sm-6">
                                                        <label>Entregar a: </label><br>
                                                        <p>
                                                                <?php 
                                                                if($entregarA == 'usuario'){
                                                                    
                                                                    for($i=0; $i<$longitud12; $i++){
                                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                        $nombreuser12 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$entregarAID[$i]'");
                                                                        $columna12 = $nombreuser12->fetch_array(MYSQLI_ASSOC);
                                                                    
                                                                        echo $columna12['nombres']." ".$columna12['apellidos'];echo "<br>";
                                                                     
                                                                    }
                                                                 
                                                                }else{
                                                                    
                                                                    for($i=0; $i<$longitud12; $i++){
                                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                    $nombrecargo12 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$entregarAID[$i]'");
                                                                    $columna12 = $nombrecargo12->fetch_array(MYSQLI_ASSOC);
                                                                    echo $columna12['nombreCargos'];echo "<br>";
                                                                    }
                                                                }
                                                                
                                                                ?>
                                                                
                                                            </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label>Comentarios: </label>
                                                            <div class="card-body">
                                                                <div style="padding: 20px;" class="tab-pane" id="timeline">
                                                                            <!-- The timeline -->
                                                                            <div class="timeline timeline-inverse">
                                                                              <!-- timeline time label -->
                                                                              <?php 
                                                                                $idSol = $datosDoc['id_solicitud'];
                                                                                $queryControl = $mysqli->query("SELECT * FROM controlCambiosCompromisos WHERE idCompromiso = '$idCompromiso'")or die(mysqli_error($mysqli));
                                                                                
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
                                                                                  
                                                                                  <h3 class="timeline-header border-0"><a href="#"><?php echo $nombreUsuario?></a> <?php echo $row['comentario'].' - '.$row['historia']?>
                                                                                  </h3>
                                                                                </div>
                                                                              </div>
                                                                            <?php }?>
                                                                            </div>
                                                                         </div>
                                                              </div>
                                                        </div>
                                               
                                                    </div>
                                            
                                            
                                            
                                            </div>
                                            <?php $n++;  }?>
                                        </div>
                                      </div>
                                      <!-- /.card-body -->
                                      <?php
                                      if($comentario != NULL){
                                      ?>
                                        <div class = "row">
                                            <div class="card-body">
                                                            <div style="padding: 20px;" class="tab-pane" id="timeline">
                                                                        <!-- The timeline -->
                                                                        <div class="timeline timeline-inverse">
                                                                          <!-- timeline time label -->
                                                                          <div class="time-label">
                                                                            <span class="bg-danger">
                                                                              Motivo de aprobación ó rechazo
                                                                            </span>
                                                                          </div>
                                
                                                                          <div>
                                                                            <i class="fas fa-user bg-info"></i>
                                                    
                                                                            <div class="timeline-item">
                                                                              
                                                                              <h3 class="timeline-header border-0"><a href="#"><?php echo $enviarNombreRechazo; ?></a>
                                                                                <?php 
                                                                                    
                                                                                        echo $comentario;
                                                                                    
                                                                                ?>
                                                                              </h3>
                                                                            </div>
                                                                          </div>
                                                                        </div>
                                                                     </div>
                                                          </div>
                                        </div>                  
                                    <?php
                                      }
                                    ?>
                                    
                                      <div class="card-footer">
                                        
                                      </div>
                                      <!-- /.card-footer-->
                                    </div>
                                    <!-- /.card -->
                                  </div>
                                </div>
                                </form>
                        </div>
                                        </div>
        
                    </section>
                                </div>
                                <!-- /.card-body -->
                                <?php
                                    if($permitidoEstado == TRUE){        
                                            $requiereEstado = "required";    
                                        ?>
                                         <form role="form" action="controlador/actas/controller" method="POST">
                                        <center>
                                            <!-- <div class="container-fluid">-->
                                <div class="row">
                                    <div class="col"></div>
                                            <section  class="container">
                                                <div class="row">
                                                    <div class="card-body">
                                                        <section class="container-fluid" >
                                                          <div class="row">
                                                             <div class="card-body">    
                                                                    <div class="form-group col-md-12 no-print">
                                                                        <label>Aprobar el acta: </label><br>
                                                                        <div class="form-group col-md-6">
                                                                            <label>Estado:</label><br>
                                                                            <select name="estado" class="form-control" <?php echo $requiereEstado; ?>>
                                                                              <option value="">Seleccione Opción</option>
                                                                              <option value="Aprobado">Aprobado</option>
                                                                              
                                                                                <?php
                                                                                /// si el acta ya se encuentra aprobada no debe permitirme rechazarlo
                                                                                if($estado == 'Aprobado'){
                                                                                ?>
                                                                                   
                                                                                <?
                                                                                }else{
                                                                                ?>php
                                                                                    <option value="Rechazado">Rechazado</option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                              
                                                                            </select><br>
                                                                            <label>Detalles de aprobación: </label><br>
                                                                            <textarea rows="2" cols="100" class="form-control" name="comentarioACTA" autocomplete="off" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"></textarea>
                                                                            <br>
                                                                            <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                                                                            <button class="btn btn-primary float-right" type="submit" name="estadoActa">Actualizar estado acta.</button>
                                                                        </div>
                                                                    </div>
                                                               </div>
                                                          </div>       
                                                          <!--<a onclick="javascript:window.print()" class="btn btn-primary btn-raised float-right no-print" style="color:white;" >Imprimir</a>-->
                                     
                                                        </section>
                                                    </div>    
                                            </center>
                                            </form>
                                              
                    
                                    
                                    <div class="card-footer" >
                                        <div class="container-fluid float-right">
                                    <!--
                                     <button onclick="printDiv('')" class="btn btn-primary btn-raised float-right" style="color:black;" ><a target="_blank" style="color:white;" href="#" rel="modal:close">Imprimir</a></button>
                                    -->
                                   
                                    
                                    
                                 
                             
                    
                            
                               
                            
                            <!-- /.row -->
                          </div><!-- /.container-fluid -->
                          
                       
                        
                        
                        <!-- COMPROMISOS-->
                        
                        
                        <!-- COMPROMISOS-->
                        
                        <!-- /.content -->
                      </div>
                      <!-- /.content-wrapper -->
                    <?php //echo require_once'footer.php'; ?>
                    
                      <!-- Control Sidebar -->
                      <aside class="control-sidebar control-sidebar-dark">
                        <!-- Control sidebar content goes here -->
                      </aside>
                      <!-- /.control-sidebar -->
                </div>
                                            </section>
                                </div>
                                                
                                <?php 
                                }
                                ?> 
                                        
                                        
                </div>
                  <!-- /.información del  acta -->
    
                  <!-- botón para imprimir el formato -->
                  <div class="row no-print">
                    <div class="col-12">
                      
                       <form action="pdf/impresion_acta" method="post" target="_blank">
                            <input name="idActa" value="<?php echo $idActa?>" type="hidden">
                            <button type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-print"></i> Imprimir
                            </button>
                        </form>
                     <!--
                      <button type="button" onclick="window.print();return false;" class="btn btn-primary float-right" style="margin-right: 5px;">
                        <i class="fas fa-print"></i> Imprimir
                      </button>
                      -->
                    </div>
                  </div>
                </div> 
                    
                

                    
                        
                  
                </div>
                
             
                
                </div>
               
               
           
            </div>
           
    
  
  </div>
</div>
  <!-- /.content-wrapper -->
<?php //echo require_once'footer.php'; ?>

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
<script type="text/javascript">
	/*Con este script imprimo el informe*/
	function printDiv(nombreDiv) {
	    var contenido= document.getElementById(nombreDiv).innerHTML;
 	    var contenidoOriginal= document.body.innerHTML;
	    document.body.innerHTML = contenido;
	    window.print();
	    document.body.innerHTML = contenidoOriginal;
	}
</script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>

<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1',
            {
                extraPlugins: 'save-to-pdf',
                pdfHandler: 'savetopdf/savetopdf.php'
            } );
</script>
</body>
</html>
<?php
}
?>