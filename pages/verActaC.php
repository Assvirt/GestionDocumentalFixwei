<?php
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';


$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];

?>
<!DOCTYPE html> 
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Ver acta</title>
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
 <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
  <style>
    .pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
  </style>
<style>
    .page { width: 21cm; min-height: 29.7cm; padding: 2cm; margin: 1cm auto; border: 1px #D3D3D3 solid; border-radius: 5px; background: white; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); }

</style>

</head>
<body class="hold-transition sidebar-mini">
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
            <h1>Ver acta</h1>
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
                        if( $longitud3 != NULL){
                            $longitud3 = count($compromisosID);
                        }
                        $convocados = $col['convocado'];
                        $convocadosID = json_decode($col['convocadoID']);
                        $convocadosID2 = json_decode($col['convocadoID']);
                        if($longitud4 != NULL){
                            $longitud4 = count($convocadosID);
                        }
                        $asistentes = $col['asistente'];
                        $asistentesID = json_decode($col['asistenteID']);
                        if($longitud5 != NULL){
                            $longitud5 = count($asistentesID);
                        }
                        //aqui va todo lo de EXTERNOS
                        $jsonConvocado = json_decode($col['nombreConvocadoEXT']);
                        if($longitud6 != NULL){
                            $longitud6 = count($jsonConvocado);
                        }
                        $jsonTipo = json_decode($col['tipoEmpresaCovEXT']);
                        if( $longitud7 = NULL){
                            $longitud7 = count($jsonTipo);
                        }
                        $jsonNombre = json_decode($col['nombreEmpresa']);
                        if($longitud8 != NULL){
                            $longitud8 = count($jsonNombre);
                        }
                        $jsonCargo = json_decode($col['cargoConvocadoEXT']);
                        //var_dump($jsonCargo);
                        if($longitud9 != NULL){
                            $longitud9 = count($jsonCargo);
                        }
                        
                        ///////
                        
                        $permisoActa = $col['permisosActa'];  /// usuario, grupo o cargo
                        $publico = $col['publico'];  // si o no
                        $responsablesID = json_decode($col['responsablesActa']); 
                        if($longitud10 != NULL){
                            $longitud10 = count($responsablesID);
                        }
                        $editor = $col['acta'];
                        $comentario = $col['comentario'];
                        $nombrePDF = $col['rutaArchivo'];
                        
                        $estado = $col['estado'];
                        
                        $idEncabezado=$col['idEncabezado'];
                    }
    
    ?>
    
    
    <!-- Main content -->
    <section class="content">
        <form role="form" action="controlador/actas/controller" method="POST">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-12">
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body page">
                    <div class="row" id="infoActa">
                        
                        <div class="form-group col-md-12">
                            <center>
                                <?php
                               
                                    $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE id = '$idEncabezado' ");
                                    $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                                    echo $encabezado['encabezado'];
                                
                                
                                ?>
                            </center>
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
                                        
                                        $nombreuser = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienCitaID[$i]'");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna['nombres']." ".$columna['apellidos']; echo "<br>";
                                     
                                    }
                                 
                                }else{
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienCitaID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    echo $columna['nombreCargos']; echo "<br>";
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
                                        
                                        $nombreuser2 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienElaboraID[$i]'");
                                        $columna2 = $nombreuser2->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna2['nombres']." ".$columna2['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }else{
                                    
                                    for($i=0; $i<$longitud2; $i++){
                                    $nombrecargo2 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraID[$i]'");
                                    $columna2 = $nombrecargo2->fetch_array(MYSQLI_ASSOC);
                                    echo $columna2['nombreCargos'];echo "<br>";
                                    }
                                }
                                
                                ?>
                                
                            </p>
                        </div>
                        
                        <!--<div class="form-group col-md-6">
                            <label>¿Los compromisos del acta requieren aprobación? : </label><br>
                            <?php
                            /*if($aprobacion == 'si'){
                                echo "Si";
                            ?>
                            
                            
                            <p>
                                <?php 
                                if($compromisos == 'usuario'){
                                    
                                    for($i=0; $i<$longitud3; $i++){
                                        
                                        $nombreuser3 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$compromisosID[$i]'");
                                        $columna3 = $nombreuser3->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna3['nombres']." ".$columna3['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }else{
                                    
                                    for($i=0; $i<$longitud3; $i++){
                                    $nombrecargo3 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$compromisosID[$i]'");
                                    $columna3 = $nombrecargo3->fetch_array(MYSQLI_ASSOC);
                                    echo $columna3['nombreCargos'];echo "<br>";
                                    }
                                }
                                
                                ?>
                                
                            </p>
                            <?php
                            }else{
                                echo "No";
                            }*/
                            ?>
                        </div>-->
                        
                        
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
                                        
                                        $nombreuser3 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$selectActaAprobacion[$i]'");
                                        $columna3 = $nombreuser3->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $enviarNombreRechazo=$columna3['nombres']." ".$columna3['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }else{
                                    
                                    for($i=0; $i<$longitudActas; $i++){
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
                                        
                                        
                                        $nombreuser6 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$responsablesID[$i]'");
                                        $columna6 = $nombreuser6->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna6['nombres']." ".$columna6['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }elseif($permisoActa == 'grupo'){
                                    
                                    
                                    for($i=0; $i<$longitud10; $i++){
                                    $nombrecargo6 = $mysqli->query("SELECT nombre FROM grupo WHERE id = '$responsablesID[$i]'");
                                    $columna6 = $nombrecargo6->fetch_array(MYSQLI_ASSOC);
                                    echo $columna6['nombre'];echo "<br>";
                                    }
                                }
                                else{
                                    
                                    
                                    for($i=0; $i<$longitud10; $i++){
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
                            <label>Desarrollo del acta: </label>
                                
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
                        
                        
                        <div class="form-group col-sm-12"  >
                            <?php
                            $ocultarPDF=$_POST['ocultarPDF'];
                            if($ocultarPDF == 'true'){
                                $displayNone="none";
                            }else{
                                $displayNone="";
                            }
                            ?>
                            <div id="example1" style="display:<?php echo$displayNone; ?>;"></div>
                            <!--Ckeditor-->
                            <script>
                                CKEDITOR.replace( 'editor1',
                                        {
                                            extraPlugins: 'save-to-pdf',
                                            pdfHandler: 'savetopdf/savetopdf.php'
                                        } );
                            </script>
                            <script>PDFObject.embed("archivos/actas/<?php echo $nombrePDF;?>", "#example1");</script>
                        </div> 
                        

                        
                </div>
                <!-- /.form-group -->
              
        
                  <!--
                  
                  ACA SE AGREGAN ELEMENTOS NUEVOS

                  -->
                  
                
                  
                </div>
                <!-- /.card-body -->
                <?php
                    if($permitidoEstado == TRUE){        
                            $requiereEstado = "required";    
                        ?>
                        <center>
                            <div class="form-group col-md-12">
                                <label>Aprobar el acta: </label><br>
                                <div class="form-group col-md-6">
                                    <label>Estado:</label><br>
                                    <select name="estado" class="form-control" <?php echo $requiereEstado; ?>>
                                      <option value="">Seleccione Opción</option>
                                      <option value="Aprobado">Aprobado</option>
                                      <option value="Rechazado">Rechazado</option>
                                    </select><br>
                                    <label>Detalles de aprobación: <label><br>
                                    <textarea rows="2" cols="100" class="form-control" name="comentarioACTA"></textarea>
                                    <br>
                                    <input type="hidden" name="idActa" value="<?php echo $idActa;?>">
                                    <button class="btn btn-primary float-right" type="submit" name="estadoActa">Actualizar estado acta.</button>
                                </div>
                            </div>
                        </center>
                        <?php } ?>    

                
                
                <div class="card-footer" >
                    <div class="container-fluid float-right">
                        <!--
                            <button onclick="print()" class="btn btn-primary btn-raised float-right" style="color:black;" ><a target="_blank" style="color:white;" href="#" rel="modal:close">Imprimir</a></button>
                        -->
                    </form>
                    <?php
                    if($displayNone != NULL){
                        $ocultandoImprimirSi="";
                    }else{
                        $ocultandoImprimirSi="none";
                    }
                    ?>
                     <a onclick="javascript:window.print()" class="btn btn-primary btn-raised float-right" style="color:white;display:<?php echo$ocultandoImprimirSi; ?>;" >Imprimir</a>
                   
                    
                   <form action="" method="POST"  style="display:<?php echo$displayNone; ?>;">
                       <input value="<?php echo $idActa;?>" name="idActa" type="hidden" readonly required>
                       <input name="ocultarPDF" value="true" type="hidden" readonly required>
                        <button id="validarImprimir" class="btn btn-primary btn-raised float-right" style="color:white;" >Validar imprimir</button>
                   </form>
                    
                    <?php 
                    /*
                        if($permisoEditar == TRUE){
                        ?>
                        
                            <form action="editarActaC" method="POST">
                                <input type="hidden" value="<?php echo $idActa?>" name="idActa">
                                <button type="submit" class="btn btn-success btn-raised float-right" style="color:white;" >Editar</button>
                            </form>
                     
                    <?php } */ ?>
                    
                    
                    </div>  
                </div>
              
            </div>
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      
    </section>
    
    <!-- ACTA
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  
                  <div class="col-12">
                    <!-- Default box 
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Desarrollo del acta</h3>
        
                        
                      </div>
                      <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <textarea name="editor1" required> <div id="canvas_div_pdf" name="canvas_div_pdf"><?php echo $editor; ?></div></textarea>
                            </div>
                        </div>
                      </div>
                      <!-- /.card-body 
                      <div class="card-footer">
                           <button id="btnImprimir" class="btn btn-primary">IMPRIMIR ACTA</button><br>
                           <input type="button" onclick="printDiv('canvas_div_pdf')" value="imprimir div" />
                      </div>
                      <!-- /.card-footer
                    </div>
                    <!-- /.card 
                  </div>
                  <div class="col"></div>
                </div>
                
        </div>
        
    </section>
    
   ACTA-->
    
    <!-- COMPROMISOS-->
    
    <?php 
        $compromisos = $mysqli->query("SELECT * FROM compromisos WHERE idActa = '$idActa' ORDER BY id ASC");
    ?>
    
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  
                  <div class="col-12">
                    <!-- Default box -->
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Compromisos</h3>
        
                        
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
                            <div class="col-md-12 border border-primary rounded" style="margin: 10px; padding:10px;">
                                
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
                                                                    $estadoCompromiso = $datosArchivo['estado'];
                                                    
                                                    
                                                           
                                                    if($rutaArchivo != NULL){
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
                                                                $queryControl = $mysqli->query("SELECT * FROM controlCambiosCompromisos WHERE idCompromiso = '$idCompromiso' ")or die(mysqli_error($mysqli));
                                                                
                                                                while($row = $queryControl->fetch_assoc()){
                                                                    $idUser = $row['usuario'];
                                                                    $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                                    $datosUser = $queryUser->fetch_assoc();
                    
                                                                    $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                                    
                                                              ?>
                                                              
                                                              <div class="time-label">
                                                                <span class="bg-danger">
                                                                  <?php echo $row['fecha']?>
                                                                </span>
                                                              </div>
                    
                                                              <div>
                                                                <i class="fas fa-user bg-info"></i>
                                        
                                                                <div class="timeline-item">
                                                                  
                                                                  <h3 class="timeline-header border-0"><a href="#"><?php echo $nombreUsuario?></a> <?php echo $row['comentario']?>
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
                      <?php /*
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
                                    
                            ?>
                            <div class="col-md-12 border border-primary rounded" style="margin: 10px; padding:10px;">
                            <div class="form-group col-md-12">
                                <h3>Compromiso N° <?php echo $n;?></h3>
                            </div>
                            <div class="form-group col-md-12">
                                
                                <label>Detalles del compromiso:</label><br>
                                <span><?php echo $compromiso;?></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Responsable: </label><br>
                                <p>
                                        <?php 
                                        if($responsableCompromiso == 'usuario'){
                                            
                                            for($i=0; $i<$longitud11; $i++){
                                                
                                                $nombreuser11 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$responsableCompromisoID[$i]'");
                                                $columna11 = $nombreuser11->fetch_array(MYSQLI_ASSOC);
                                            
                                                echo $columna11['nombres']." ".$columna11['apellidos'];echo "<br>";
                                             
                                            }
                                         
                                        }else{
                                            
                                            for($i=0; $i<$longitud11; $i++){
                                            $nombrecargo11 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$responsableCompromisoID[$i]'");
                                            $columna11 = $nombrecargo11->fetch_array(MYSQLI_ASSOC);
                                            echo $columna11['nombreCargos'];echo "<br>";
                                            }
                                        }
                                        
                                        ?>
                                        
                                    </p>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label>Fecha entrega:</label><br>
                                <span><?php echo $fechaFormato;?></span>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label>Entregar a: </label><br>
                                <p>
                                        <?php 
                                        if($entregarA == 'usuario'){
                                            
                                            for($i=0; $i<$longitud12; $i++){
                                                
                                                $nombreuser12 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$entregarAID[$i]'");
                                                $columna12 = $nombreuser12->fetch_array(MYSQLI_ASSOC);
                                            
                                                echo $columna12['nombres']." ".$columna12['apellidos'];echo "<br>";
                                             
                                            }
                                         
                                        }else{
                                            
                                            for($i=0; $i<$longitud12; $i++){
                                            $nombrecargo12 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$entregarAID[$i]'");
                                            $columna12 = $nombrecargo12->fetch_array(MYSQLI_ASSOC);
                                            echo $columna12['nombreCargos'];echo "<br>";
                                            }
                                        }
                                        
                                        ?>
                                        
                                    </p>
                            </div>
                            </div>
                            <?php $n++;  }?>
                        </div>
                      </div>
                      */
                      ?>
                      <!-- /.card-body -->
                      <?php
                      if($comentario != NULL){
                      ?>
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
                    <?php
                      }
                    ?>
                      <div class="card-footer">
                        
                      </div>
                      <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
                </form>
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



</body>
</html>
<?php
}
?>